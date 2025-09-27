<?php

$tpl = erLhcoreClassTemplate::getInstance('lhfbmessenger/campaignsms.tpl.php');

$response = null;
$campaignObj = null;
$fbOptions = erLhcoreClassModelChatConfig::fetch('fbmessenger_options');
$data = (array)$fbOptions->data;

// Extraer restricciones de campaña
$restricciones = [];
foreach ($data as $key => $value) {
    if (strpos($key, 'campaign_') === 0) {
        $restricciones[$key] = $value;
    }
}

$tpl->set('restricciones', $restricciones);



if (isset($_POST['send'])) {
    $phonesRaw      = trim($_POST['phones'] ?? '');
    $phonesArr      = array_filter(array_map('trim', explode(',', $phonesRaw)));
    $message        = trim($_POST['message'] ?? '');
    $campaignName   = trim($_POST['campaign'] ?? '');
    $scheduledAtRaw = trim($_POST['scheduled_at'] ?? '');

    // 🔹 Listas seleccionadas
    $selectedLists = $_POST['ml'] ?? [];
    $allPhonesFromLists = [];

    if (!empty($selectedLists)) {
        // 1. Obtener relaciones lista-contacto
        $relations = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppContactListContact::getList([
            'filterin' => ['contact_list_id' => $selectedLists]
        ]);

        // 2. Recorrer relaciones y traer cada contacto
        foreach ($relations as $rel) {
            $contact = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppContact::fetch($rel->contact_id);
            if ($contact && !empty($contact->phone)) {
                $allPhonesFromLists[] = trim($contact->phone);
            }
        }
    }

    // 🔹 Combinar teléfonos: manuales + de listas
    $phonesArr = array_unique(array_merge($phonesArr, $allPhonesFromLists));

    // Normalizar fecha programada
    $scheduledAt = 0;
    if ($scheduledAtRaw !== '') {
        $ts = strtotime($scheduledAtRaw);
        if ($ts !== false) {
            $scheduledAt = $ts;
        }
    }

    // Guardar campaña
    $campaignObj = new erLhcoreClassModelSmsCampaign();
    $campaignObj->name         = $campaignName;
    $campaignObj->message      = $message;
    $campaignObj->phones       = implode(',', $phonesArr);
    $campaignObj->scheduled_at = $scheduledAt;
    $campaignObj->created_at   = time();
    $campaignObj->updated_at   = time();

    // 🔹 Estado inicial
    $campaignObj->status = 'pending';

    $session = erLhcoreClassExtensionFbmessenger::getSession();
    $session->save($campaignObj);

    // Respuesta
    if ($campaignObj->status === 'pending') {
        $response = "Campaña programada para " . date('Y-m-d H:i', $campaignObj->scheduled_at);
    } else {
        $response = "Campaña creada y lista para ser procesada por el cron.";
    }
}

// Pasar variables a la vista
$tpl->set('response', $response);
$tpl->set('campaign', $campaignObj);

$Result['content'] = $tpl->fetch();
$Result['path'] = [
    [
        'url'   => erLhcoreClassDesign::baseurl('fbmessenger/list_campaign_sms'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Campañas SMS')
    ],
    [
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Crear campañas')
    ]
];
