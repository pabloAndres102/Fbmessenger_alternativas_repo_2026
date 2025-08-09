<?php

$tpl = erLhcoreClassTemplate::getInstance('lhfbwhatsappmessaging/modal_recipient.tpl.php');

$item = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppContact::fetch($Params['user_parameters']['id']);
$tpl->set('item',$item);

echo $tpl->fetch();
exit;

?>