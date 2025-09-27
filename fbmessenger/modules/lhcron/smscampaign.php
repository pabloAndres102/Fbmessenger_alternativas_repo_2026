<?php

/**
 * Ejecutar con:
 * php cron.php -s site_admin -e fbmessenger -c cron/smscampaign
 */

$db = ezcDbInstance::get();
$now = time();

// Paso 1: Cambiar campañas pendientes a in_process si ya llegó la hora
$db->beginTransaction();
try {
    $stmt = $db->prepare("
        UPDATE lhc_sns_sms_campaign 
        SET status = :status_in_process 
        WHERE status = :status_pending 
        AND (
            scheduled_at = 0 
            OR (scheduled_at > 0 AND scheduled_at <= :ts)
        )
    ");

    $stmt->bindValue(':status_in_process', 'in_process', PDO::PARAM_STR);
    $stmt->bindValue(':status_pending', 'pending', PDO::PARAM_STR);
    $stmt->bindValue(':ts', $now, PDO::PARAM_INT);
    $stmt->execute();

    $db->commit();
} catch (Exception $e) {
    $db->rollback();
    return;
}

// Paso 2: Seleccionar campañas a procesar
$db->beginTransaction();
try {
    $stmt = $db->prepare('
        SELECT id 
        FROM lhc_sns_sms_campaign 
        WHERE status = :status 
        LIMIT :limit 
        FOR UPDATE
    ');
    $stmt->bindValue(':status', 'in_process', PDO::PARAM_STR);
    $stmt->bindValue(':limit', 5, PDO::PARAM_INT); // Máx. 5 campañas por corrida
    $stmt->execute();

    $campaignsId = $stmt->fetchAll(PDO::FETCH_COLUMN);

    if (!empty($campaignsId)) {
        // Bloquear campañas como "sending"
        $stmt = $db->prepare('
            UPDATE lhc_sns_sms_campaign 
            SET status = :status 
            WHERE id IN (' . implode(',', $campaignsId) . ')
        ');
        $stmt->bindValue(':status', 'sending', PDO::PARAM_STR);
        $stmt->execute();
        $db->commit();
    } else {
        $db->rollback();
        return;
    }
} catch (Exception $e) {
    $db->rollback();
    return;
}

// Paso 3: Procesar campañas
$campaigns = erLhcoreClassModelSmsCampaign::getList([
    'filterin' => ['id' => $campaignsId]
]);

foreach ($campaigns as $campaign) {
    $phones = array_filter(array_map('trim', explode(',', $campaign->phones)));
    $allSent = true;

    foreach ($phones as $phone) {
        $result = erLhcoreClassModelSms::sendSMS($phone, $campaign->message, $campaign->name);

        if ($result['status'] !== 'sent') {
            $allSent = false;
            echo "[FAIL] {$phone} - {$result['error']}\n";
        } else {
            echo "[OK] {$phone} enviado\n";
        }
    }

    // Actualizar estado de campaña
    $campaign->status = $allSent ? 'sent' : 'failed';
    $campaign->updated_at = time();
    $campaign->updateThis(['update' => ['status', 'updated_at']]);
}
