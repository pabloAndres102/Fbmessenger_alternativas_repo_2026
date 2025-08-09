<?php
$response = erLhcoreClassChatEventDispatcher::getInstance()->dispatch('fbwhatsapp.delete', array());
$fbOptions = erLhcoreClassModelChatConfig::fetch('fbmessenger_options');
$data = (array)$fbOptions->data;
$tpl = erLhcoreClassTemplate::getInstance('lhfbwhatsapp/templates.tpl.php');

$Result['content'] = $tpl->fetch();
$Result['path'] = array(array('title' => erTranslationClassLhTranslation::getInstance()->getTranslation('fbwhatsapp', 'Form')));


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $template_name = strtolower($_POST['template_name']);

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://graph.facebook.com/v17.0/'.$data['whatsapp_business_account_id'].'/message_templates?name=' . $template_name . '',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'DELETE',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ' . $data['whatsapp_access_token']
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    $deleteResponse = json_decode($response);

    if (isset($deleteResponse->success) && $deleteResponse->success === true) {
        $_SESSION['delete_template_message'] = 'La plantilla se eliminó con éxito.';
    } elseif (isset($deleteResponse->error->error_user_msg)) {
        $_SESSION['delete_template_error'] = $deleteResponse->error->error_user_msg;
    } else {
        // Si no hay éxito ni mensaje de error específico, muestra un mensaje de error genérico
        $_SESSION['delete_template_error'] = $response;
    }

    header('Location: ' . erLhcoreClassDesign::baseurl('fbwhatsapp/templates'));
}
