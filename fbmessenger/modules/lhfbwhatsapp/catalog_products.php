<?php

$tpl = erLhcoreClassTemplate::getInstance('lhfbwhatsapp/catalog_products.tpl.php');
$fbOptions = erLhcoreClassModelChatConfig::fetch('fbmessenger_options');
$data = (array)$fbOptions->data;



$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://graph.facebook.com/v22.0/' . $data['whatsapp_business_account_phone_number'] . '/whatsapp_commerce_settings',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'Authorization:  Bearer ' . $data['whatsapp_access_token']
    ),
));



$response = curl_exec($curl);


$jsonResponse = json_decode($response, true);

$is_cart_enabled = $jsonResponse['data'][0]['is_cart_enabled'];
$is_catalog_visible =  $jsonResponse['data'][0]['is_catalog_visible'];


if ($data['whatsapp_business_account_phone_number']) {
    if ($is_cart_enabled == true) {
        $url = 'https://graph.facebook.com/v22.0/' . $data['whatsapp_business_account_phone_number'] . '/whatsapp_commerce_settings?is_cart_enabled=false&is_catalog_visible=false';
        $status_catalog = 'Catalogo activado';
    } else {
        $url = 'https://graph.facebook.com/v22.0/' . $data['whatsapp_business_account_phone_number'] . '/whatsapp_commerce_settings?is_cart_enabled=true&is_catalog_visible=true';
        $status_catalog = 'Catalogo desactivado';
    }
} else {
    $_SESSION['set'] = 'Por favor, ingrese Business phone number ID';
}

curl_close($curl);


if (isset($_POST['action'])) {
    $action = $_POST["action"];

    $curl = curl_init();



    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ' . $data['whatsapp_access_token']
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    header('Location: ' . erLhcoreClassDesign::baseurl('fbwhatsapp/catalog_products'));

}
$products = erLhcoreClassModelCatalog::getList();
$tpl->set('products', $products);
$tpl->set('status_catalog', $status_catalog);

$Result['content'] = $tpl->fetch();

$Result['path'] = array(
    array(
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Catalog')
    )
);
