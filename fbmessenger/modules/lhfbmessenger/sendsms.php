<?php

$tpl = erLhcoreClassTemplate::getInstance('lhfbmessenger/sendsms.tpl.php');

$response = null;

if (isset($_POST['send'])) {
    $phone   = trim($_POST['phone']);
    $message = trim($_POST['message']);

    // Ahora usamos directamente la clase unificada
    $response = erLhcoreClassModelSms::sendSMS($phone, $message);

    $tpl->set('response', $response);
}

$Result['content'] = $tpl->fetch();
$Result['path'] = array(
    array(
        'url'   => erLhcoreClassDesign::baseurl('fbmessenger/index'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'SMS')
    )
);
