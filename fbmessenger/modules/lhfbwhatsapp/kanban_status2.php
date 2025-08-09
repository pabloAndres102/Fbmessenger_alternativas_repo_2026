<?php

$tpl = erLhcoreClassTemplate::getInstance('lhfbwhatsapp/kanban_status2.tpl.php');

if (isset($_GET['id'])) {
    $chat_id = $_GET['id'];
    $chat = erLhcoreClassModelChat::fetch($chat_id);
    $kanban_status = erLhcoreClassModelKanban::getList();

    $tpl->set('chat', $chat);
    $tpl->set('kanban_status', $kanban_status);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['kanban_status'])) {
    $chat_id = $_POST['chat_id'];
    $new_status = $_POST['kanban_status'];

    $chat = erLhcoreClassModelChat::fetch($chat_id);
    $previous_status = $chat->kanban_id; 
    
    $chat->kanban_id = $new_status; 
    $chat->saveThis();

    if ($previous_status != $new_status) {
        $advice = 'El estado de Kanban se ha actualizado correctamente.';
    } else {
        $advice = 'No hubo cambios en el estado de Kanban.';
    }
    $tpl->set('advice', $advice);
}

echo $tpl->fetch();
exit;

?>
