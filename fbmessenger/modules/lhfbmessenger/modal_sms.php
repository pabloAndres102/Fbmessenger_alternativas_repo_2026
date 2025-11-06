<?php

$tpl = erLhcoreClassTemplate::getInstance('lhfbmessenger/modal_sms.tpl.php');

// Si llega solicitud AJAX (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['phone'], $_POST['message'])) {
    $phone = trim($_POST['phone']);
    $message = trim($_POST['message']);

    header('Content-Type: application/json');

    if ($phone === '' || $message === '') {
        echo json_encode(['status' => 'error', 'message' => 'Faltan datos para enviar el SMS.']);
        exit;
    }

    try {
        // 🚀 Lógica real de envío (ajusta esta línea a tu función real)
        $response = erLhcoreClassModelSms::sendSMS($phone, $message);

        echo json_encode([
            'status' => 'success',
            'message' => 'SMS enviado correctamente.',
            'data' => [
                'MessageId' => $response['MessageId'] ?? 'N/A',
                'Telefono' => $phone
            ]
        ]);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error al enviar: ' . $e->getMessage()]);
    }

    exit; // Evita renderizar la plantilla
}

// Si no es POST, carga normalmente la vista
echo $tpl->fetch();
exit;
