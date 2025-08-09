<?php

$tpl = erLhcoreClassTemplate::getInstance('lhfbwhatsapp/messages_stats.tpl.php');

$id = $_GET['id'];

if ($id != 9) {
  $messages = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::getList(['filter' => ['status' => $id]]);
}else{
  $messages = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::getList(['filtergt' => ['chat_id' => 0]]);
}


$instance =  LiveHelperChatExtension\fbmessenger\providers\FBMessengerWhatsAppLiveHelperChat::getInstance();
$templates = $instance->getTemplates();

$template = $templates[0];

$tpl->set('template', $template);


$tpl->set('messages', $messages);


$Result['content'] = $tpl->fetch();
$Result['path'] = array(
  array(
    'url' => erLhcoreClassDesign::baseurl('fbmessenger/index'),
    'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Facebook chat')
  ),
  array(
    'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Message stats')
  )
);
