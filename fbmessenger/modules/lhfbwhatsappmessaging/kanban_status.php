<?php

$tpl = erLhcoreClassTemplate::getInstance('lhfbwhatsappmessaging/kanban_status.tpl.php');

$status = erLhcoreClassModelKanban::getList();


$tpl->set('status',$status);


if ($currentUser->hasAccessTo('lhfbwhatsappmessaging', 'delete_status')) {
    $tpl->set('delete_status', true);
} else {
    $tpl->set('delete_status', false);
}

if ($currentUser->hasAccessTo('lhfbwhatsappmessaging', 'edit_status')) {
    $tpl->set('edit_status', true);
} else {
    $tpl->set('edit_status', false);
}

if ($currentUser->hasAccessTo('lhfbwhatsappmessaging', 'create_status')) {
    $tpl->set('create_status', true);
} else {
    $tpl->set('create_status', false);
}






$Result['path'] = array(
    array(
        'url' => erLhcoreClassDesign::baseurl('fbwhatsappmessaging/kanban'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger','Kanban'),
    ),
    array(
        'url' => erLhcoreClassDesign::baseurl('fbwhatsappmessaging/kanban_status'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger','Estatus kanban'),
    ),
);


$Result['content'] = $tpl->fetch();