<?php

$tpl = erLhcoreClassTemplate::getInstance('lhfbwhatsapp/validate_email.tpl.php');

$db = ezcDbInstance::get();


// -------------------------------
// Configuración de límite
// -------------------------------
$MONTH_LIMIT = 50000;
$currentMonth = date('Y-m');

// -------------------------------
// Obtener / crear registro mensual
// -------------------------------
$stmt = $db->prepare("SELECT * FROM lhc_fbmessenger_validators WHERE month_year = ?");
$stmt->execute([$currentMonth]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    $stmt = $db->prepare("
        INSERT INTO lhc_fbmessenger_validators 
        (month_year, email_request_count, request_count, created_at)
        VALUES (?, 0, 0, ?)
    ");
    $stmt->execute([$currentMonth, time()]);
    $emailCount = 0;
} else {
    $emailCount = (int)$row['email_request_count'];
}

// Enviar contador a la vista
$tpl->set('emailRequestCount', $emailCount);
$tpl->set('emailLimit', $MONTH_LIMIT);

// -------------------------------
// Procesar POST
// -------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $results = [];
    $emails = [];
    $emailsInput = '';

    // CSV
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] === UPLOAD_ERR_OK) {

        $fileTmpPath = $_FILES['csv_file']['tmp_name'];
        $csvData = array_map('str_getcsv', file($fileTmpPath));

        $header = array_map('trim', $csvData[0]);
        unset($csvData[0]);

        $emailIndex = -1;
        foreach ($header as $i => $col) {
            if (strtolower($col) === 'email') {
                $emailIndex = $i;
                break;
            }
        }

        if ($emailIndex === -1) {
            $tpl->set('error', 'El archivo CSV debe contener una columna llamada "EMAIL".');
        } else {
            foreach ($csvData as $rowCSV) {
                $email = trim($rowCSV[$emailIndex] ?? '');
                if ($email !== '') {
                    $emails[] = $email;
                }
            }
        }
    }

    // Manual
    elseif (!empty($_POST['emails'])) {
        $emailsInput = trim($_POST['emails']);
        $emails = preg_split('/[\s,]+/', $emailsInput, -1, PREG_SPLIT_NO_EMPTY);
    }

    // -------------------------------
    // Control de límite mensual
    // -------------------------------
    if (!empty($emails)) {

        $available = $MONTH_LIMIT - $emailCount;

        if ($available <= 0) {
            $tpl->set('error', "❌ Has alcanzado el límite mensual de {$MONTH_LIMIT} validaciones de email.");
        } else {

            // Limitar cantidad
            if (count($emails) > $available) {
                $emails = array_slice($emails, 0, $available);
                $tpl->set('warning', "⚠ Se procesaron solo {$available} correos por el límite mensual.");
            }

            $apiKey = 'sub_1S6Nm0AJu6gy4fiY2XAFhqvo';

            foreach ($emails as $email) {

                // ---------------------------
                // Incrementar contador
                // ---------------------------
                $stmt = $db->prepare("
                    UPDATE lhc_fbmessenger_validators
                    SET email_request_count = email_request_count + 1,
                        created_at = ?
                    WHERE month_year = ?
                ");
                $stmt->execute([time(), $currentMonth]);
                $emailCount++;

                // ---------------------------
                // Llamada API
                // ---------------------------
                $url = "https://happy.mailtester.ninja/ninja?email=" . urlencode($email) . "&key=" . $apiKey;

                $curl = curl_init();
                curl_setopt_array($curl, [
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_TIMEOUT => 30,
                ]);

                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);

                if ($err) {
                    $results[] = [
                        'email' => $email,
                        'code' => 'error',
                        'message' => "Error: $err",
                        'domain' => '',
                        'mx' => ''
                    ];
                } else {
                    $data = json_decode($response, true);
                    $results[] = [
                        'email' => $data['email'] ?? $email,
                        'code' => $data['code'] ?? 'unknown',
                        'message' => $data['message'] ?? '',
                        'domain' => $data['domain'] ?? '',
                        'mx' => $data['mx'] ?? ''
                    ];
                }
            }
        }
    }

    $tpl->set('emailsInput', $emailsInput);
    $tpl->set('results', $results);
    $tpl->set('emailRequestCount', $emailCount);
}

// Render base
$Result['content'] = $tpl->fetch();
$Result['path'] = [
    [
        'url' => erLhcoreClassDesign::baseurl('fbwhatsapp/validator'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Validador')
    ],
    [
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Validate email')
    ],
];
