<?php if (($chat->iwh_id > 0 && ($incomingWebhook = erLhcoreClassModelChatIncomingWebhook::fetch($chat->iwh_id)) instanceof erLhcoreClassModelChatIncomingWebhook) && $incomingWebhook->scope == 'facebookwhatsappscope' && max($chat->last_user_msg_time,$chat->pnd_time) < time() - 24 * 3600 ) : ?>
    <div class="position-absolute alert alert-danger p-1 m-2">
        <span class="text-muted fw-bold text-white"><span class="material-icons text-danger">warning</span> Ya no puedes recuperar esta sesión, debes enviar una plantilla</span></a>
    </div>
<?php endif; ?>

