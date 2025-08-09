<?php
$response = erLhcoreClassChatEventDispatcher::getInstance()->dispatch('fbwhatsapp.analytics', array());
$fbOptions = erLhcoreClassModelChatConfig::fetch('fbmessenger_options');
$data = (array)$fbOptions->data;
$tpl = erLhcoreClassTemplate::getInstance('lhfbwhatsapp/analytics.tpl.php');


$instance = \LiveHelperChatExtension\fbmessenger\providers\FBMessengerWhatsAppLiveHelperChat::getInstance();
$phones = $instance->getPhones();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


$start = $_POST['start'];
$end = $_POST['end'];

$phoneNumber = $_POST['phone_number'];
$granularity = $_POST['granularity'];

$json_response = $instance->getConversationMetrics($start,$end,$granularity,$phoneNumber);

$tpl->set('data',$json_response); 

}
$tpl->set('phones',$phones);

$Result['content'] = $tpl->fetch();
$Result['path'] = array(
    array(
        'url' => erLhcoreClassDesign::baseurl('fbmessenger/index'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Facebook chat')
    ),
    array(
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Analytics')
    ),
);
