<?php 
$response = erLhcoreClassChatEventDispatcher::getInstance()->dispatch('fbwhatsapp.createflow', array());
$fbOptions = erLhcoreClassModelChatConfig::fetch('fbmessenger_options');
$data = (array)$fbOptions->data;
$tpl = erLhcoreClassTemplate::getInstance('lhfbwhatsapp/createflow.tpl.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name_flow = $_POST['name_flow'];
    $categorie = $_POST['categorie'];

    // Crear un array asociativo con los datos que deseas enviar
    $postData = array(
        'name' => $name_flow,
        'categories' => $categorie
    );

    // Convertir el array en una cadena JSON
    $jsonPostData = json_encode($postData);

    $curl = curl_init();
    
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://graph.facebook.com/v18.0/'.$data['whatsapp_business_account_id'].'/flows',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $jsonPostData,  // Aquí se establece la cadena JSON como POSTFIELDS
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer '.$data['whatsapp_access_token']
        ),
    ));
    
    $response = curl_exec($curl);
    $response = json_decode($response, true);   
    // print_r($response); 
    curl_close($curl);
}

$Result['content'] = $tpl->fetch();
$Result['path'] = array(
    array('url' => erLhcoreClassDesign::baseurl('fbmessenger/index'), 
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger','Facebook chat')),
    array(
        'url' => erLhcoreClassDesign::baseurl('fbwhatsapp/flows'), 
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Flows')),
    array(
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Create')),    
);
?>
