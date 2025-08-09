<?php

if (!$currentUser->validateCSFRToken($Params['user_parameters_unordered']['csfr'])) {
    die('Invalid CSFR Token');
    exit;
}

try {
    $item = LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppContactList::fetch( $Params['user_parameters']['id']);
    if ($item->can_delete) {

        $relaciones = LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppContactListContact::getList(['filter' => ['contact_list_id' => $Params['user_parameters']['id']]]);
        $contactos = LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppContactListContact::getList();
        foreach($contactos as $contacto){
            foreach($relaciones as $relacion){
            if($relacion->contact_id == $contacto->id){
                $deleteContact = LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppContact::fetch($contacto->id);
                $deleteContact->removeThis();
            }
        }
    }

        $item->removeThis();
        erLhcoreClassModule::redirect('fbwhatsappmessaging/mailinglist');
        exit;
    } else {
        throw new Exception('No permission to edit!');
    }
} catch (Exception $e) {
    $tpl = erLhcoreClassTemplate::getInstance('lhkernel/validation_error.tpl.php');
    $tpl->set('errors',array($e->getMessage()));
    $Result['content'] = $tpl->fetch();
}



?>