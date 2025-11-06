<?php

$tpl = erLhcoreClassTemplate::getInstance('lhfbwhatsapp/validate_number.tpl.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $results = [];
    $numbers = [];
    $numbersInput = '';

    // 🔹 Caso 1: CSV importado
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['csv_file']['tmp_name'];
        $csvData = array_map('str_getcsv', file($fileTmpPath));

        // Detectar encabezado "NUMERO" (ignorando mayúsculas)
        $header = array_map('trim', $csvData[0]);
        unset($csvData[0]);

        $numeroIndex = -1;
        foreach ($header as $i => $col) {
            if (strtolower($col) === 'numero') {
                $numeroIndex = $i;
                break;
            }
        }

        if ($numeroIndex === -1) {
            $tpl->set('error', 'El archivo CSV debe contener una columna llamada "NUMERO".');
        } else {
            foreach ($csvData as $row) {
                $number = trim($row[$numeroIndex] ?? '');
                if ($number !== '') {
                    $numbers[] = $number;
                }
            }
        }
    }

    // 🔹 Caso 2: Números ingresados manualmente
    elseif (!empty($_POST['numbers'])) {
        $numbersInput = trim($_POST['numbers']);
        $numbers = preg_split('/[\s,]+/', $numbersInput, -1, PREG_SPLIT_NO_EMPTY);
    }

    // 🔹 Validar cada número (si existen)
    if (!empty($numbers)) {
        foreach ($numbers as $number) {
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => "https://whatsapp-number-validator3.p.rapidapi.com/WhatsappNumberHasItWithToken",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode(['phone_number' => $number]),
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json",
                    "x-rapidapi-host: whatsapp-number-validator3.p.rapidapi.com",
                    "x-rapidapi-key: 0037da949dmshc36eb413714b3dap1c93b4jsnfcf383270aa5"
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            if ($err) {
                $results[] = [
                    'number' => $number,
                    'status' => 'error',
                    'message' => "Error: $err"
                ];
            } else {
                $data = json_decode($response, true);
                $results[] = [
                    'number' => $number,
                    'status' => $data['status'] ?? 'unknown',
                    'message' => $data['message'] ?? '',
                    'details' => $data
                ];
            }
        }
    }

    $tpl->set('numbersInput', $numbersInput);
    $tpl->set('results', $results);
}

// Renderizado base
$Result['content'] = $tpl->fetch();
$Result['path'] = [
    [
        'url' => erLhcoreClassDesign::baseurl('fbwhatsapp/validate_number'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Validator')
    ]
];
