<?php

$tpl = erLhcoreClassTemplate::getInstance('lhfbwhatsapp/validator.tpl.php');

// Título y descripción opcional
$Result['content'] = $tpl->fetch();
$Result['path'] = [
    [
        'url' => erLhcoreClassDesign::baseurl('validator/validator'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/validator', 'Validadores')
    ]
];
