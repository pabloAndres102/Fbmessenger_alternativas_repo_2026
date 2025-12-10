<?php

$tpl = erLhcoreClassTemplate::getInstance('lhfbwhatsapp/validate_number.tpl.php');

$db = ezcDbInstance::get();
// ---------------------------------------------------------
// Validar permisos de usuario
// ---------------------------------------------------------
$currentUser = erLhcoreClassUser::instance();


// ---------------------------------------
// Configuración del límite mensual
// ----------------------------------------
$MONTH_LIMIT = 5000;
$currentMonth = date('Y-m'); // Ej: 2025-12

// ----------------------------------------
// Obtener o crear registro del mes actual
// ----------------------------------------
$stmt = $db->prepare("SELECT * FROM lhc_fbmessenger_validators WHERE month_year = :m LIMIT 1");
$stmt->execute([':m' => $currentMonth]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    $db->query("INSERT INTO lhc_fbmessenger_validators (month_year, request_count, created_at) 
                VALUES ('{$currentMonth}', 0, " . time() . ")");
    $currentCount = 0;
} else {
    $currentCount = (int)$row['request_count'];
}

$tpl->set('requestCount', $currentCount);
$tpl->set('monthLimit', $MONTH_LIMIT);
$tpl->set('currentMonth', $currentMonth);

// ---------------------------------------------------------
// Procesamiento del formulario
// ---------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $results = [];
    $numbers = [];
    $numbersInput = '';

    // ---------------------------------------------------------
    // CSV
    // ---------------------------------------------------------
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] === UPLOAD_ERR_OK) {

        $fileTmpPath = $_FILES['csv_file']['tmp_name'];
        $csvData = array_map('str_getcsv', file($fileTmpPath));

        $header = array_map('trim', $csvData[0] ?? []);
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
            foreach ($csvData as $rowCsv) {
                $number = trim($rowCsv[$numeroIndex] ?? '');
                if ($number !== '') {
                    $numbers[] = $number;
                }
            }
        }
    }


    // ---------------------------------------------------------
    // Manual
    // ---------------------------------------------------------
    elseif (!empty($_POST['numbers'])) {
        $numbersInput = trim($_POST['numbers']);
        $numbers = preg_split('/[\s,]+/', $numbersInput, -1, PREG_SPLIT_NO_EMPTY);
    }

    // ---------------------------------------------------------
    // Validación con control de límite
    // ---------------------------------------------------------
    if (!empty($numbers)) {

        $allowed = $MONTH_LIMIT - $currentCount;
        $totalRequested = count($numbers);

        if ($totalRequested > $allowed) {
            $tpl->set('error', "🚫 Límite mensual alcanzado. Solo puedes validar {$allowed} números más este mes.");
            $numbers = array_slice($numbers, 0, $allowed);
        }

        foreach ($numbers as $number) {

            // ⛔ Doble protección de límite
            if ($currentCount >= $MONTH_LIMIT) {
                $tpl->set('error', '🚫 Límite mensual de validaciones alcanzado (5000).');
                break;
            }

            // 🔢 Incrementar contador
            $stmt = $db->prepare("UPDATE lhc_fbmessenger_validators 
                                  SET request_count = request_count + 1, 
                                      created_at = :t
                                  WHERE month_year = :m");
            $stmt->execute([
                ':t' => time(),
                ':m' => $currentMonth
            ]);

            $currentCount++;

            // ------------------------------
            // Llamada a la API
            // ------------------------------
            $payload = json_encode([
                'phone_number' => $number
            ]);

            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://whatsapp-number-validator3.p.rapidapi.com/WhatsappNumberHasItWithToken",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $payload,
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
                    'message' => "Error CURL: $err"
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
    $tpl->set('requestCount', $currentCount);
}

// ---------------------------------------------------------
// Render
// ---------------------------------------------------------
$Result['content'] = $tpl->fetch();
$Result['path'] = [
    [
        'url' => erLhcoreClassDesign::baseurl('fbwhatsapp/validator'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Validator')
    ],
    [
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Validate number')
    ],

];
