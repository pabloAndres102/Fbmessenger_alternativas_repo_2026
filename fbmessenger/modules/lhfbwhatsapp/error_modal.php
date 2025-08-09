<?php
$tpl = erLhcoreClassTemplate::getInstance('lhfbwhatsapp/error_modal.tpl.php');

$item = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::fetch($Params['user_parameters']['id']);
$tpl->set('item', $item);

$errorMessage = '';
$errorData = '';

if (isset($item->send_status_raw)) {
    $rawData = $item->send_status_raw;

    // Buscar el mensaje de error en el JSON
    if (preg_match('/"message":"(.*?)"/', $rawData, $matches)) {
        $errorMessage = $matches[1];
    }

    // Buscar el contenido de error_data en el JSON
    if (preg_match('/"error_data":({.*?})/', $rawData, $matches)) {
        $errorData = $matches[1];
    }
}

$tpl->set('errorMessage', $errorMessage);
$tpl->set('errorData', $errorData);

echo $tpl->fetch();
exit;
