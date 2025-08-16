<?php

$tpl = erLhcoreClassTemplate::getInstance('lhfbwhatsappmessaging/contact_history.tpl.php');
$instance = \LiveHelperChatExtension\fbmessenger\providers\FBMessengerWhatsAppLiveHelperChat::getInstance();
$phone = isset($_GET['phone']) ? (int)$_GET['phone'] : 0;


$status_contact = LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::getList(['filter' => ['phone' =>  $phone]]);


$tpl->set('items', $status_contact);

if (isset($_POST['phone_off'], $_POST['action'])) {
    $contact = LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppContact::getList(['filter' => ['phone' => $_POST['phone_off']]]);
    if (!empty($contact)) {
        foreach ($contact as $id_contact) {
            $fetch_contact = LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppContact::fetch($id_contact->id);
            if ($_POST['action'] === 'toggle') {
                if ($fetch_contact->disabled == 0) {
                    $fetch_contact->disabled = 1;
                    $_SESSION['activate'] = 'El contacto fue desactivado con exito.';
                } else {
                    $fetch_contact->disabled = 0;
                    $_SESSION['activate'] = 'El contacto fue activado con exito.';
                    $_SESSION['warning'] = 'Recuerde asignarlo a una lista si así lo requiere. <a href="' . erLhcoreClassDesign::baseurl('fbwhatsappmessaging/mailingrecipient') . '">Aquí</a>';
                }
            }
            $fetch_contact->saveThis();
        }
    }
}




$Result['content'] = $tpl->fetch();
$Result['path'] = [
    [
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Contact history')
    ]
];
