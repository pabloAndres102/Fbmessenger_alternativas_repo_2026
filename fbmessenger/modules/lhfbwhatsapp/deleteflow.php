<?php
$response = erLhcoreClassChatEventDispatcher::getInstance()->dispatch('fbwhatsapp.deleteflow', array());
$fbOptions = erLhcoreClassModelChatConfig::fetch('fbmessenger_options');
$data = (array)$fbOptions->data;
$tpl = erLhcoreClassTemplate::getInstance('lhfbwhatsapp/flows.tpl.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $flow_id = strtolower($_POST['flow_id']);

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://graph.facebook.com/v18.0/' . $flow_id . '',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'DELETE',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ' . $data['whatsapp_access_token'] . ''
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    header('Location: ' . erLhcoreClassDesign::baseurl('fbwhatsapp/flows'));
}
