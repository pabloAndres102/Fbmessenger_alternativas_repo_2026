<?php

$tpl = erLhcoreClassTemplate::getInstance('lhfbwhatsappmessaging/restrictions.tpl.php');

$fbOptions = erLhcoreClassModelChatConfig::fetch('fbmessenger_options');
$data = (array)$fbOptions->data;

$days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

if (isset($_POST['StoreRestrictions'])) {

    if (!isset($_POST['csfr_token']) || !$currentUser->validateCSFRToken($_POST['csfr_token'])) {
        erLhcoreClassModule::redirect('fbwhatsappmessaging/restrictions');
        exit;
    }

    $definition = [];

    // Validaciones para cada día
    foreach ($days as $day) {
        $definition["campaign_{$day}_start"] = new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL,
            'unsafe_raw'
        );
        $definition["campaign_{$day}_end"] = new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL,
            'unsafe_raw'
        );
    }

    $form = new ezcInputForm(INPUT_POST, $definition);

    foreach ($days as $day) {
        if ($form->hasValidData("campaign_{$day}_start") && preg_match('/^\d{2}:\d{2}$/', $form->{"campaign_{$day}_start"})) {
            $data["campaign_{$day}_start"] = $form->{"campaign_{$day}_start"};
        } else {
            $data["campaign_{$day}_start"] = '08:00';
        }

        if ($form->hasValidData("campaign_{$day}_end") && preg_match('/^\d{2}:\d{2}$/', $form->{"campaign_{$day}_end"})) {
            $data["campaign_{$day}_end"] = $form->{"campaign_{$day}_end"};
        } else {
            $data["campaign_{$day}_end"] = '19:00';
        }
    }

    $fbOptions->explain = '';
    $fbOptions->type = 0;
    $fbOptions->hidden = 1;
    $fbOptions->identifier = 'fbmessenger_options';
    $fbOptions->value = serialize($data);
    $fbOptions->saveThis();

    $tpl->set('updated', 'done');
}


$tpl->set('fb_options', $data);

$Result['content'] = $tpl->fetch();
$Result['path'] = array(
    array(
        'url' => erLhcoreClassDesign::baseurl('fbwhatsappmessaging/restrictions'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Restrictions')
    )
);
