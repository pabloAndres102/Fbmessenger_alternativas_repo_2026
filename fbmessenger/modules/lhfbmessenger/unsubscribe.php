<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

$phone = $_GET['phone'] ?? null;
$isBrowser = isset($_SERVER['HTTP_ACCEPT']) && str_contains($_SERVER['HTTP_ACCEPT'], 'text/html');
$response = [];

try {
    if (!$phone) {
        throw new Exception('Falta el parámetro "phone".');
    }

    $db = ezcDbInstance::get();

    $stmt = $db->prepare('SELECT * FROM lhc_fbmessengerwhatsapp_contact WHERE phone = :phone');
    $stmt->bindValue(':phone', $phone);
    $stmt->execute();

    $contact = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$contact) {
        throw new Exception('No se encontró ningún contacto con ese número.');
    }

    if ((int)$contact['disabled'] === 1) {
        throw new Exception('Este número ya está desuscrito previamente.');
    }

    $update = $db->prepare('UPDATE lhc_fbmessengerwhatsapp_contact SET disabled = 1 WHERE id = :id');
    $update->bindValue(':id', $contact['id']);
    $update->execute();

    $response = [
        'success' => true,
        'message' => 'Tu número ha sido desuscrito correctamente.',
        'phone' => $phone
    ];
} catch (Exception $e) {
    $response = [
        'success' => false,
        'error' => $e->getMessage()
    ];
}

/* Si la petición viene del navegador, mostrar una página bonita */
if ($isBrowser) {
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Desuscripción</title>
        <style>
            body {
                font-family: 'Segoe UI', Roboto, sans-serif;
                background: #f9fafb;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }
            .card {
                background: white;
                padding: 2rem;
                border-radius: 16px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.1);
                text-align: center;
                max-width: 420px;
            }
            .icon {
                font-size: 4rem;
                margin-bottom: 1rem;
            }
            .success { color: #16a34a; }
            .error { color: #dc2626; }
            h1 { margin: 0.5rem 0; }
            p { color: #444; font-size: 1.1rem; }
        </style>
    </head>
    <body>
        <div class="card">
            <?php if ($response['success']): ?>
                <div class="icon success">✅</div>
                <h1>¡Desuscripción exitosa!</h1>
                <p><?= htmlspecialchars($response['message']) ?></p>
            <?php else: ?>
                <div class="icon error">❌</div>
                <h1>No se pudo completar la solicitud</h1>
                <p><?= htmlspecialchars($response['error']) ?></p>
            <?php endif; ?>
        </div>
    </body>
    </html>
    <?php
} else {
    // Si no es navegador, responder JSON (API)
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response);
}
exit;
