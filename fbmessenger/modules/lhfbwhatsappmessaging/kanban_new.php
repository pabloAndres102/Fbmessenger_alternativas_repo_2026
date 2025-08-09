<?php

$tpl = erLhcoreClassTemplate::getInstance('lhfbwhatsappmessaging/kanban_new.tpl.php');



if(isset($_POST['name_status']) && isset($_POST['color'])){
        $new_kanban_status = new erLhcoreClassModelKanban();
        $new_kanban_status->nombre = $_POST['name_status'];
        $new_kanban_status->color = $_POST['color'];
        $new_kanban_status->posicion = $_POST['position'];
        $new_kanban_status->saveThis();
        erLhcoreClassModule::redirect('fbwhatsappmessaging/kanban_status');
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
    array(
        'url' => erLhcoreClassDesign::baseurl('fbwhatsappmessaging/kanban_new'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger','New kanban status'),
    )
);


$Result['content'] = $tpl->fetch();