<?php

$tpl = erLhcoreClassTemplate::getInstance('lhfbmessenger/unsubscribe.tpl.php');

$phone = $_GET['phone'] ?? null;
$response = null;

if ($phone) {

    $db = ezcDbInstance::get();
    $stmt = $db->prepare('SELECT * FROM lhc_fbmessengerwhatsapp_contact WHERE phone = :phone');
    $stmt->bindValue(':phone', $phone);
    $stmt->execute();

    $contact = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($contact) {

        // Si ya está deshabilitado, mostramos un mensaje acorde
        if ((int)$contact['disabled'] === 1) {
            $response = [
                'success' => false,
                'error' => 'Este número ya está desuscrito previamente.'
            ];
        } else {
            // Marcamos el contacto como desuscrito
            $update = $db->prepare('UPDATE lhc_fbmessengerwhatsapp_contact SET disabled = 1 WHERE id = :id');
            $update->bindValue(':id', $contact['id']);
            $update->execute();

            $response = [
                'success' => true,
                'phone' => $phone
            ];
        }

    } else {
        $response = [
            'success' => false,
            'error' => 'No se encontró ningún contacto con ese número.'
        ];
    }

} else {
    $response = [
        'success' => false,
        'error' => 'Falta el parámetro "phone" en la URL.'
    ];
}

$tpl->set('response', $response);
$Result['content'] = $tpl->fetch();
$Result['pagelayout'] = 'login'; // layout público
