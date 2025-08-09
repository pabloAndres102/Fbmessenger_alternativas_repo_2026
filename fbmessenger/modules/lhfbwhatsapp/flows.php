<?php

$response = erLhcoreClassChatEventDispatcher::getInstance()->dispatch('fbwhatsapp.flows', array());
$fbOptions = erLhcoreClassModelChatConfig::fetch('fbmessenger_options');
$data = (array)$fbOptions->data;
$tpl = erLhcoreClassTemplate::getInstance('lhfbwhatsapp/flows.tpl.php');

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://graph.facebook.com/v18.0/'.$data['whatsapp_business_account_id'].'/flows',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer '.$data['whatsapp_access_token'].''
  ),
));



$response = curl_exec($curl);
$response = json_decode($response, true);
$tpl->set('flows',$response);
curl_close($curl);

$Result['content'] = $tpl->fetch();
$Result['path'] = array(
    array('url' => erLhcoreClassDesign::baseurl('fbmessenger/index'), 
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger','Facebook chat')),
    array(
      'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Flows')
  )
);