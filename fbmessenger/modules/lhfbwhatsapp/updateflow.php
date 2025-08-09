<?php
$response = erLhcoreClassChatEventDispatcher::getInstance()->dispatch('fbwhatsapp.updateflow', array());
$fbOptions = erLhcoreClassModelChatConfig::fetch('fbmessenger_options');
$data = (array)$fbOptions->data;
$tpl = erLhcoreClassTemplate::getInstance('lhfbwhatsapp/updateflow.tpl.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Procesar el formulario y enviar los datos con cURL
    $flowId = $_POST['flow_id'];
    $jsonFile = $_FILES['json_file']['tmp_name'];
    $assetType = 'FLOW_JSON';
    $nombre_archivo = $_FILES["json_file"]["name"];

    // Verificar si el archivo es un JSON válido
    $jsonData = file_get_contents($jsonFile);
    $jsonData = json_decode($jsonData);

    if ($jsonData === null) {
        echo "El archivo no es un JSON válido.";
    } else {
        $curl = curl_init();

        $postData = array(
            'file' => new CURLFile($jsonFile, 'application/json'), // Establece el tipo MIME como application/json
            'name' => $nombre_archivo,
            'asset_type' => $assetType
        );

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://graph.facebook.com/v18.0/' . $flowId . '/assets',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$data['whatsapp_access_token'] 
            ),
        ));

        $response = curl_exec($curl);
        $jsonresponse = json_decode($response,true);
        // print_r($jsonresponse);
        curl_close($curl);

    }
}

$Result['content'] = $tpl->fetch();
$Result['path'] = array(
    array(
        'url' => erLhcoreClassDesign::baseurl('fbmessenger/index'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Facebook chat')
    ),
    array(
        'url' => erLhcoreClassDesign::baseurl('fbwhatsapp/flows'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Flows')
    ),
    array(
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Update a flow')
    ),
);

?>

