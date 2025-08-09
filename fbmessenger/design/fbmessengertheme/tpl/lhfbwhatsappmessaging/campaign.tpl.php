<h1><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Campaigns list'); ?></h1>

<?php include(erLhcoreClassDesign::designtpl('lhfbwhatsappmessaging/parts/search_panel_mailinglist.tpl.php')); ?>
<a class="btn btn-secondary btn-sm" href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/newcampaign') ?>"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Create campaign'); ?></a>
<br>
<br>
<?php if (isset($items)) : ?>
<?php
// Comprueba si hay un mensaje de éxito en la variable de sesión
if (isset($_SESSION['activate'])) {
    echo '<div class="alert alert-success">' . $_SESSION['activate'] . '</div>';
    // Elimina el mensaje de éxito de la variable de sesión para que no se muestre nuevamente después de la recarga
    unset($_SESSION['activate']);
}

if (isset($_SESSION['create'])) {
    echo '<div class="alert alert-success">' . $_SESSION['create'] . '</div>';
    unset($_SESSION['create']);
}

// Comprueba si hay un mensaje de error en la variable de sesión
if (isset($_SESSION['deactivate'])) {
    echo '<div class="alert alert-warning">' . $_SESSION['deactivate'] . '</div>';
    // Elimina el mensaje de error de la variable de sesión para que no se muestre nuevamente después de la recarga
    unset($_SESSION['deactivate']);
}

if (isset($_SESSION['email_send_status'])) {
    $status = $_SESSION['email_send_status']['type'];
    $message = $_SESSION['email_send_status']['message'];

    // Muestra el mensaje con el fondo correspondiente
    $alertClass = ($status == 'success') ? 'alert-success' : 'alert-danger';

    echo '<div class="alert ' . $alertClass . '">' . $message . '</div>';

    // Limpia la variable de sesión para que no se muestre nuevamente después de la recarga
    unset($_SESSION['email_send_status']);
}
?>

    <table cellpadding="0" cellspacing="0" class="table table-sm table-hover" width="100%" ng-non-bindable>
        <thead>
            <tr>
                <th width="1%"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'ID'); ?></th>
                <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Name'); ?></th>
                <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Owner'); ?></th>
                <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Type'); ?></th>
                <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Status'); ?></th>
                <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Date scheduled'); ?></th>
                <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Recipients'); ?></th>
                <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Statistics'); ?></th>
                <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Actions'); ?></th>
                <th width="1%"></th>
            </tr>
        </thead>
        <?php foreach ($items as $item) : ?>
            <tr class="<?php if ($item->status == LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaign::STATUS_FINISHED) : ?>text-muted<?php endif; ?>">
                <td><?php echo $item->id ?></td>
                <td>
                    <a class="csfr-post text-muted csfr-required" title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Copy campaign'); ?>" href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaign') ?>/(action)/copy/(id)/<?php echo $item->id ?>"><i class="material-icons mr-0">content_copy</i></a>

                    <?php if ($item->can_edit) : ?>
                        <a class="<?php if ($item->status == LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaign::STATUS_FINISHED) : ?>text-muted<?php endif; ?>" href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/editcampaign') ?>/<?php echo $item->id ?>/?template=<?php echo $item->template ?>"><span class="material-icons">edit</span><?php echo htmlspecialchars($item->name) ?></a>
                    <?php else : ?>
                        <span class="material-icons">edit_off</span><?php echo htmlspecialchars($item->name) ?>
                    <?php endif; ?>
                </td>
                <td>
                    <?php print_r($item->user->username) ?>
                </td>
                <td>
                    <?php if ($item->private == LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaign::LIST_PUBLIC) : ?>
                        <span class="material-icons">public</span><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Public'); ?>
                    <?php else : ?>
                        <span class="material-icons">vpn_lock</span><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Private'); ?>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($item->enabled == 0) : ?>
                        <span class="material-icons" title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Not active'); ?>">hourglass_disabled</span>
                    <?php else : ?>
                        <span class="material-icons" title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Active'); ?>">hourglass_empty</span>
                    <?php endif; ?>
                    <?php if ($item->status == LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaign::STATUS_PENDING) : ?>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Pending'); ?>
                    <?php elseif ($item->status == LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaign::STATUS_IN_PROGRESS) : ?>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'In progress'); ?>
                    <?php elseif ($item->status == LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaign::STATUS_FINISHED) : ?>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Finished'); ?>
                        &nbsp;&nbsp;(<?php print_r(date('d-m-Y H:i', $item->finished_at)) ?>)
                    <?php endif; ?>
                </td>
                <td class="<?php
                            if ($item->status == LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaign::STATUS_PENDING) {
                                echo 'text-warning';
                            } elseif ($item->status == LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaign::STATUS_IN_PROGRESS) {
                                echo 'text-primary';
                            } elseif ($item->status == LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaign::STATUS_FINISHED) {
                                echo 'text-success';
                            } ?>">
                    <?php if ($item->starts_at > 0) : ?>
                        <span><?php echo date('Y-m-d H:i', $item->starts_at) ?></span>
                    <?php else : ?>
                        -
                    <?php endif; ?>
                </td>
                <td>
                    <a class="<?php if ($item->status == LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaign::STATUS_FINISHED) : ?>text-muted<?php endif; ?>" href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaignrecipient') ?>/(campaign)/<?php echo $item->id ?>"><span class="material-icons">list</span><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'List of recipients'); ?> (<?php echo $item->total_contacts ?>)</a>
                </td>
                <td>
                    <a class="btn btn-primary btn-sm bg-dark text-white" href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/statistic_campaign') ?>/?id=<?php echo $item->id ?>">
                        <span class="material-icons">equalizer</span>
                    </a>
                </td>
                <td>
                    <?php if ($item->enabled == 1) : ?>
                        <form action="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/togglecampaign') ?>" style="display: inline-block; margin-right: 5px;" method="post">
                            <input type="hidden" name="campaign_id" value="<?php echo $item->id ?>">
                            <input type="hidden" name="action" value="deactivate">
                            <button type="submit" class="btn btn-secondary btn-sm"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Deactivate'); ?></button>
                        </form>
                    <?php else : ?>
                        <form action="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/togglecampaign') ?>" method="post" style="display: inline-block; margin-right: 5px;" onsubmit="return validateActivation(<?php echo $item->total_contacts; ?>)">
                            <input type="hidden" name="campaign_id" value="<?php echo $item->id ?>">
                            <input type="hidden" name="action" value="activate">
                            <button type="submit" class="btn btn-success btn-sm"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Activate'); ?></button>
                        </form>
                    <?php endif; ?>
                    <?php if ($item->can_delete) : ?>
                        <a class="btn btn-danger btn-sm csfr-post csfr-required" onclick="return confirm('<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('kernel/messages', 'Are you sure?'); ?>')" href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/deletecampaign') ?>/<?php echo $item->id ?>"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Delete'); ?></a>
                    <?php endif; ?>
                </td>

            </tr>
        <?php endforeach; ?>
    </table>

    <?php include(erLhcoreClassDesign::designtpl('lhkernel/secure_links.tpl.php')); ?>

    <?php if (isset($pages)) : ?>
        <?php include(erLhcoreClassDesign::designtpl('lhkernel/paginator.tpl.php')); ?>
    <?php endif; ?>
<?php endif; ?>


<script>
    function validateActivation(totalContacts) {
        // Verificar si total_contacts es igual a 0
        if (totalContacts === 0) {
            // Mostrar un alert y evitar que se envíe el formulario
            alert("La campaña no puede ser activada porque no tiene destinatarios.");
            return false;
        }

        // Permitir el envío del formulario si total_contacts no es igual a 0
        return true;
    }
</script>