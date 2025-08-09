<?php

$tpl = erLhcoreClassTemplate::getInstance('lhfbwhatsapp/messageview.tpl.php');

$item = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::fetch($Params['user_parameters']['id']);
$tpl->set('item',$item);

echo $tpl->fetch();
exit;

?>