<?php

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;

$instance = \LiveHelperChatExtension\fbmessenger\providers\FBMessengerWhatsAppLiveHelperChat::getInstance();

$tpl = erLhcoreClassTemplate::getInstance('lhfbwhatsapp/qr.tpl.php');
$phones = $instance->getPhones();

$qrDataList = [];

foreach ($phones as $phone) {
    // Limpiar el número para API de WhatsApp (quitar espacios y "+")
    $cleanPhone = preg_replace('/\D+/', '', $phone['display_phone_number']);

    $whatsappUrl = 'https://api.whatsapp.com/send?phone=' . $cleanPhone;

    // Generar QR
    $result = Builder::create()
        ->writer(new PngWriter())
        ->data($whatsappUrl)
        ->encoding(new Encoding('UTF-8'))
        ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
        ->size(300)
        ->margin(10)
        ->build();

    $qrImageData = 'data:image/png;base64,' . base64_encode($result->getString());

    // Guardar datos para la vista
    $qrDataList[] = [
        'verified_name' => $phone['verified_name'],
        'display_phone_number' => $phone['display_phone_number'],
        'whatsapp_url' => $whatsappUrl,
        'qr_image' => $qrImageData
    ];
}

$tpl->set('qrDataList', $qrDataList);

$Result['content'] = $tpl->fetch();
$Result['path'] = [
    [
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'QR')
    ]
];
