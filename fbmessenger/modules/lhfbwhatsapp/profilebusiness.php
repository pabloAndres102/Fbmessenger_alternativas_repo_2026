<?php

$fbOptions = erLhcoreClassModelChatConfig::fetch('fbmessenger_options');
$data = (array)$fbOptions->data;
$tpl = erLhcoreClassTemplate::getInstance('lhfbwhatsapp/profilebusiness.tpl.php');

$phones = array_map('trim', explode(',', $data['whatsapp_business_account_phone_number']));
$tpl->set('phones', $phones);


if (isset($_POST['phone'])) {
    $_SESSION['phone'] = $_POST['phone'];
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://graph.facebook.com/v20.0/' . $_POST['phone'] . '/whatsapp_business_profile?fields=about%2Caddress%2Cdescription%2Cemail%2Cprofile_picture_url%2Cwebsites%2Cvertical',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ' . $data['whatsapp_access_token']
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $response_GET = json_decode($response, true);
}

if ($_POST['about']) {
    $profile_id_phone =  $_POST['phone_profile'];
    $messaging_product = 'whatsapp';
    $about = $_POST['about'];
    $address = $_POST['address'];
    $description = $_POST['description'];
    $vertical = $_POST['vertical'];
    $email = $_POST['email'];
    $website1 = $_POST['website1'];
    $website2 = $_POST['website2'];
    $postdata = array();
    $postdata['messaging_product'] = 'whatsapp';
    $postdata['about'] = $about;
    $postdata['description'] = $description;
    $postdata['address'] = $address;
    $postdata['vertical'] = $vertical;
    $postdata['email'] = $email;
    $postdata['websites'] = [$website1, $website2];

    $archivo_temporal = $_FILES['image']['tmp_name'];
    $nombre_archivo = $_FILES["image"]["name"];
    $tipo_archivo = $_FILES["image"]["type"];
    $tamaño_archivo = $_FILES["image"]["size"];


    if (!empty($archivo_temporal)) {
        $ch = curl_init();
        $nombre_archivo = str_replace(' ', '', $nombre_archivo);

        curl_setopt_array($ch, array(
            CURLOPT_URL => 'https://graph.facebook.com/v20.0/' . $data['app_id'] . '/uploads?file_length=' . $tamaño_archivo . '&file_type=' . $tipo_archivo . '&file_name=' . $nombre_archivo,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $data['whatsapp_access_token']
            ),
        ));

        $responseid = curl_exec($ch);
        $response_data = json_decode($responseid, true);
        $session_id = $response_data['id'];
        curl_close($ch);

        //////// UPLOAD FILE

        $ch2 = curl_init();


        curl_setopt_array($ch2, array(
            CURLOPT_URL => 'https://graph.facebook.com/v20.0/' . $session_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => file_get_contents($archivo_temporal),
            CURLOPT_HTTPHEADER => array(
                'file_offset: 0',
                'Content-Type: application/json',
                'Authorization: OAuth ' . $data['whatsapp_access_token']
            ),
        ));

        $response = curl_exec($ch2);
        $response_data2 = json_decode($response, true);

        $uploadedFileId = $response_data2['h'];
        curl_close($ch2);

        if (!empty($uploadedFileId)) {
            $postdata['profile_picture_handle'] = $uploadedFileId;
        }
    }

    $curl = curl_init();

    if (isset($postdata)) {
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://graph.facebook.com/v20.0/' .  $profile_id_phone . '/whatsapp_business_profile',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($postdata),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $data['whatsapp_access_token']
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $jsonResponse = json_decode($response, true);

        // print_r($jsonResponse);


    }
}


$tpl->set('config', $response_GET);
$Result['content'] = $tpl->fetch();
if (isset($jsonResponse['error'])) {
    $_SESSION['profile_error'] = $jsonResponse['error']['message'];
    $_SESSION['profile_error2'] = $jsonResponse['error']['error_data']['details'];
    $_SESSION['profile_error3'] = $jsonResponse['error']['error_user_title'];
    $_SESSION['profile_error4'] = $jsonResponse['error']['error_user_msg'];
} elseif (isset($jsonResponse['success'])) {
    $_SESSION['profile_success'] = 'Se ha actualizado su perfil con exito! ';
} else {
    $_SESSION['profile_unknown_error'] = $jsonResponse;
} 

if (isset($jsonResponse)) {
    header('Location: ' . erLhcoreClassDesign::baseurl('fbwhatsapp/profilebusiness'));
}

$Result['path'] = array(
    array(
        'url' => erLhcoreClassDesign::baseurl('fbmessenger/index'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('lhelasticsearch/module', 'Facebook Chat')
    ),
    array(
        'url' => erLhcoreClassDesign::baseurl('fbwhatsapp/profilebusiness'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Profile')
    )
);
