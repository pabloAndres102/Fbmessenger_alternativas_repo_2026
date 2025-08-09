<?php

if(isset($_POST['status_id'])){
    $ObjectData = erLhcoreClassModelKanban::fetch($_POST['status_id']);
    $ObjectData->removeThis();
    erLhcoreClassModule::redirect('fbwhatsappmessaging/kanban_status');
}
// solucion eliminacion de columna  


