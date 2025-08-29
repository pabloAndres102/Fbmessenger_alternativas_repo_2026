<?php

$tpl = erLhcoreClassTemplate::getInstance('lhfbwhatsappmessaging/newmailingrecipient.tpl.php');

$item = new LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppContact();

if (is_array($Params['user_parameters_unordered']['ml'])) {
    $item->ml_ids_front = $Params['user_parameters_unordered']['ml'];
}

if (ezcInputForm::hasPostData() && !(!isset($_POST['csfr_token']) || !$currentUser->validateCSFRToken($_POST['csfr_token']))) {

    $Errors = \LiveHelperChatExtension\fbmessenger\providers\FBMessengerWhatsAppMailingValidator::validateMailingRecipient($item);

    if (count($Errors) == 0) {
        try {
            $item->user_id = $currentUser->getUserID();

            // --- NUEVA LÓGICA ---
            if (isset($item->existing_contact_id)) {
                // El contacto ya existía
                foreach ($item->ml_ids as $listId) {
                    $exists = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppContactListContact::getCount([
                        'filter' => [
                            'contact_id' => $item->existing_contact_id,
                            'contact_list_id' => $listId
                        ]
                    ]);

                    if ($exists == 0) {
                        $listContact = new \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppContactListContact();
                        $listContact->contact_id = $item->existing_contact_id;
                        $listContact->contact_list_id = $listId;
                        $listContact->saveThis();
                    }
                }
            } else {
                // Contacto nuevo
                $item->saveThis();

                if ($item->isAllPrivateListMember() === true) {
                    $item->private = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppContact::LIST_PRIVATE;
                    $item->saveThis(['update' => ['private']]);
                }
            }
            // --- FIN NUEVA LÓGICA ---

            $tpl->set('updated', true);
        } catch (Exception $e) {
            $tpl->set('errors', array($e->getMessage()));
        }
    } else {
        $tpl->set('errors', $Errors);
    }
}

$tpl->set('item', $item);
$Result['content'] = $tpl->fetch();

echo $tpl->fetch();
exit;
