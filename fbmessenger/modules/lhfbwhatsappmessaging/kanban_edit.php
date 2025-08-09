<?php

$tpl = erLhcoreClassTemplate::getInstance('lhfbwhatsappmessaging/kanban_edit.tpl.php');


$status = erLhcoreClassModelKanban::fetch($_GET['status_id']);
$tpl->set('status',$status);






if(isset($_POST['name_status']) || isset($_POST['color'])){
        $edit_status = erLhcoreClassModelKanban::fetch($_POST['status_edit']);
        $edit_status->nombre = $_POST['name_status'];
        $edit_status->color = $_POST['color'];
        $edit_status->posicion =$_POST['position'];
        $edit_status->updateThis();
        erLhcoreClassModule::redirect('fbwhatsappmessaging/kanban_status');
    }





$Result['path'] = array(
    array(
        'url' => erLhcoreClassDesign::baseurl('fbwhatsappmessaging/kanban'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger','Kanban'),
    ),
    array(
        'url' => erLhcoreClassDesign::baseurl('fbwhatsappmessaging/kanban_status'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger','Status kanban'),
    ),
    array(
        'url' => erLhcoreClassDesign::baseurl('fbwhatsappmessaging/kanban_new'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger','Edit kanban status'),
    )
);


$Result['content'] = $tpl->fetch();