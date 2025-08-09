<?php
$fbOptions = erLhcoreClassModelChatConfig::fetch('fbmessenger_options');
$data = (array)$fbOptions->data;



$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://graph.facebook.com/v20.0/'.$data['whatsapp_business_account_phone_number'].'/whatsapp_commerce_settings',
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

curl_close($curl);


$action = $_POST["action"];

$curl = curl_init();



if($data['business_phone_id']){
    if ($is_cart_enabled == true) {
        $url = 'https://graph.facebook.com/v20.0/'.$data['business_phone_id'].'/whatsapp_commerce_settings?is_cart_enabled=false&is_catalog_visible=false';
        $_SESSION['desactivado'] = 'Su catalogo fue desactivado exitosamente';
    } else {
        $url = 'https://graph.facebook.com/v20.0/'.$data['business_phone_id'].'/whatsapp_commerce_settings?is_cart_enabled=true&is_catalog_visible=true';
        $_SESSION['activado'] = 'Su catalogo fue activado exitosamente';
    }
}else {
    $_SESSION['set'] = 'Por favor, ingrese Business phone number ID';
}

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

print_r($response);
header('Location: ' . erLhcoreClassDesign::baseurl('fbwhatsapp/catalog_products'));
