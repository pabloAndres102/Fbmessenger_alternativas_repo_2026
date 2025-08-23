<?php

////////////////// V2 Pablo piedrahita

// Obtenemos el ID de la campaña desde la URL
$id = (int) $Params['user_parameters']['id'];

try {

    // Cargamos la campaña
    $campaign = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaign::fetch($id);

    if ($campaign instanceof \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaign) {
        // Eliminamos la campaña
        $campaign->removeThis();
    }

    // Redirigimos de vuelta al listado de campañas
    erLhcoreClassModule::redirect('fbwhatsappmessaging/campaign');
    exit;

} catch (Exception $e) {
    $tpl = erLhcoreClassTemplate::getInstance('lhkernel/validation_error.tpl.php');
    $tpl->set('errors', array("Error al eliminar la campaña: " . $e->getMessage()));
    $Result['content'] = $tpl->fetch();
}







///////////// V1


// if (!isset($_SERVER['HTTP_X_CSRFTOKEN']) || !$currentUser->validateCSFRToken($_SERVER['HTTP_X_CSRFTOKEN'])) {
//     die('Invalid CSRF Token');
//     exit;
// }

// try {
//     $item = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaign::fetch($Params['user_parameters']['id']);
//     if ($item->can_delete) {
//         $item->removeThis();
//         erLhcoreClassModule::redirect('fbwhatsappmessaging/campaign');
//         exit;
//     } else {
//         throw new Exception('No permission to edit!');
//     }
// } catch (Exception $e) {
//     $tpl = erLhcoreClassTemplate::getInstance('lhkernel/validation_error.tpl.php');
//     $tpl->set('errors',array($e->getMessage()));
//     $Result['content'] = $tpl->fetch();
// }

?>