<?php

$tpl = erLhcoreClassTemplate::getInstance('lhfbwhatsapp/validate_email.tpl.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $results = [];
    $emails = [];
    $emailsInput = '';

    // 🔹 Caso 1: CSV importado
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['csv_file']['tmp_name'];
        $csvData = array_map('str_getcsv', file($fileTmpPath));

        // Detectar encabezado "EMAIL" (ignorando mayúsculas)
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
            foreach ($csvData as $row) {
                $email = trim($row[$emailIndex] ?? '');
                if ($email !== '') {
                    $emails[] = $email;
                }
            }
        }
    }

    // 🔹 Caso 2: Emails ingresados manualmente
    elseif (!empty($_POST['emails'])) {
        $emailsInput = trim($_POST['emails']);
        $emails = preg_split('/[\s,]+/', $emailsInput, -1, PREG_SPLIT_NO_EMPTY);
    }

    // 🔹 Validar cada email (si existen)
    if (!empty($emails)) {
        $apiKey = 'sub_1S6Nm0AJu6gy4fiY2XAFhqvo'; // 🔑 Reemplaza con tu clave real
        foreach ($emails as $email) {
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

    $tpl->set('emailsInput', $emailsInput);
    $tpl->set('results', $results);
}

// Renderizado base
$Result['content'] = $tpl->fetch();
$Result['path'] = [
    [
        'url' => erLhcoreClassDesign::baseurl('validator/validate_email'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Email Validator')
    ]
];
