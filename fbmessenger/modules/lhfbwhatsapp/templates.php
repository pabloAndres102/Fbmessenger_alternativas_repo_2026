<?php

$tpl = erLhcoreClassTemplate::getInstance('lhfbwhatsapp/templates.tpl.php');

try {
    $instance =  LiveHelperChatExtension\fbmessenger\providers\FBMessengerWhatsAppLiveHelperChat::getInstance();
    $templates = $instance->getTemplates();
} catch (Exception $e) {
    $tpl->set('error', $e->getMessage());
    $templates = [];
}

$tpl->set('templates', $templates);




use LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppTemplate;

// Crear template de prueba
$item = new erLhcoreClassModelMessageFBWhatsAppTemplate();
$item->name = 'madres_urgente';
$item->language = 'es_CO';
$item->status = erLhcoreClassModelMessageFBWhatsAppTemplate::STATUS_APPROVED;
$item->category = 'MARKETING';
$item->waba_id = '105209658989864';
$item->template_id = '691707943354092';
$item->components = json_encode([
    [
        'type' => 'BODY',
        'text' => 'Hola. Revisa nuestro catálogo para tu rápido urgente del *Día de la Madre*.'
    ],
    [
        'type' => 'BUTTONS',
        'buttons' => [
            ['type' => 'PHONE_NUMBER', 'text' => 'Llamar', 'phone_number' => '+573007193093'],
            ['type' => 'URL', 'text' => 'Nubepop.com', 'url' => 'https://nubepop.com/'],
            ['type' => 'URL', 'text' => 'Catálogo', 'url' => 'https://nubepop.com/madres.pdf']
        ]
    ]
]);

// Guardar con la lógica de LHC
$item->saveThis();

echo "Template registrado con ID interno: " . $item->id . "\n";






$Result['content'] = $tpl->fetch();
$Result['path'] = array(
    array('url' => erLhcoreClassDesign::baseurl('fbmessenger/index'), 'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger','Facebook chat')),
    array(
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Templates')
    )
);



?>