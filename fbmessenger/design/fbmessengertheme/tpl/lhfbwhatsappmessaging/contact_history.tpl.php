<?php if (isset($_SESSION['activate'])) {
    echo '<div class="alert alert-success">' . $_SESSION['activate'] . '</div>';
    if (isset($_SESSION['warning'])) {
        echo '<div class="alert alert-warning">' . $_SESSION['warning'] . '</div>';
        unset($_SESSION['warning']);
    }
    // Elimina el mensaje de éxito de la variable de sesión para que no se muestre nuevamente después de la recarga
    unset($_SESSION['activate']);
}
?>

<?php
$mostrarBoton = false;

foreach ($items as $item) {
    if (in_array($item->status, [0, 1, 6])) {
        $mostrarBoton = true;
        break; // ya encontramos uno, no hace falta seguir
    }
}
?>
<h1 class="d-flex justify-content-between align-items-center">
    <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Contact history'); ?>

    <?php if ($mostrarBoton) : ?>
        <form action="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/contact_history') ?>" method="post" class="mb-0">
            <input type="hidden" name="phone_off" value="<?php echo $item->phone ?>">
            <input type="hidden" name="action" value="toggle">
            <button type="submit"
                class="btn btn-warning btn-sm"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="Este botón aparece porque el contacto tuvo mensajes fallidos, pendientes o rechazados">
                <span class="material-icons align-middle">toggle_on</span>
                <span class="align-middle">Activar / Desactivar</span>
            </button>
        </form>
    <?php endif; ?>
</h1>

<?php if (isset($items)) : ?>

    <!-- <h1><?php print_r(\LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::getList()) ?></h1>  -->
    <table cellpadding="0" cellspacing="0" class="table table-sm" width="100%" ng-non-bindable>
        <thead>
            <tr>
                <th width="1%"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Chat'); ?></th>
                <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Account'); ?></th>
                <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Campaign'); ?></th>
                <!-- <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Type'); ?></th> -->
                <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Department'); ?></th>
                <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Date'); ?></th>
                <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Template'); ?></th>
                <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Iniciación'); ?></th>
                <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'User'); ?></th>
                <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Phone'); ?></th>
                <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Send status'); ?></th>
                <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Programmed'); ?></th>
                <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Chat'); ?></th>
                <th width="1%"></th>
            </tr>
        </thead>
        <?php foreach ($items as $item) : ?>
            <tr>
                <td nowrap="" title="<?php echo date(erLhcoreClassModule::$dateDateHourFormat, $item->created_at); ?> | <?php echo htmlspecialchars($item->fb_msg_id) ?> | <?php echo htmlspecialchars($item->conversation_id) ?>">
                    <?php echo htmlspecialchars($item->id) ?> <a class="material-icons" onclick="lhc.revealModal({'url':WWW_DIR_JAVASCRIPT+'fbwhatsapp/rawjson/<?php echo $item->id ?>'})">info_outline</a>
                </td>
                <td>
                    <?php if (is_object($item->business_account)) : ?>
                        <?php echo htmlspecialchars((string)$item->business_account) ?>
                    <?php else : ?>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Default'); ?>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($item->campaign_id > 0) : ?>
                        <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/statistic_campaign') ?>/?id=<?php echo htmlspecialchars($item->campaign_id) ?>"><?php echo htmlspecialchars((string)$item->campaign) ?></a>
                        &nbsp;&nbsp;- <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/statistic_campaign') ?>/?id=<?php echo htmlspecialchars($item->campaign_id) ?>">
                            <span class="material-icons">equalizer</span>
                        </a>

                    <?php else : ?>

                        Envío simple
                    <?php endif; ?>
                </td>
                <!-- <td>
                    <?php if ($item->private == LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::LIST_PUBLIC) : ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;<span class="material-icons">public</span>
                    <?php else : ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;<span class="material-icons">vpn_lock</span>
                    <?php endif; ?>
                </td> -->
                <td>
                    <?php echo htmlspecialchars((string)$item->department) ?>
                </td>
                <td title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Updated'); ?> <?php echo $item->updated_at_ago ?> <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'ago'); ?>">
                    <?php
                    // Establecer la configuración regional en español
                    setlocale(LC_TIME, 'es_ES.UTF-8');

                    if (!function_exists('getSpanishMonthName')) {
                        function getSpanishMonthName($monthNumber)
                        {
                            $months = [
                                1 => 'enero',
                                2 => 'febrero',
                                3 => 'marzo',
                                4 => 'abril',
                                5 => 'mayo',
                                6 => 'junio',
                                7 => 'julio',
                                8 => 'agosto',
                                9 => 'septiembre',
                                10 => 'octubre',
                                11 => 'noviembre',
                                12 => 'diciembre',
                            ];

                            return $months[$monthNumber];
                        }
                    }

                    $timestamp = strtotime($item->created_at_front);
                    $date = getdate($timestamp);

                    $formattedDate = sprintf(
                        "%d de %s de %d %02d:%02d:%02d",
                        $date['mday'],
                        getSpanishMonthName($date['mon']),
                        $date['year'],
                        $date['hours'],
                        $date['minutes'],
                        $date['seconds']
                    );

                    echo $formattedDate;
                    ?>

                </td>
                <td>
                    <?php echo htmlspecialchars((string)$item->template) ?>
                    <a class="material-icons" onclick="lhc.revealModal({'url':WWW_DIR_JAVASCRIPT+'fbwhatsapp/messageview/<?php echo $item->id ?>'})">info_outline</a>
                </td>

                <td>
                    <?php if ($item->initiation == \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::INIT_US) : ?>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Nosotros'); ?>
                    <?php else : ?>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Usuario'); ?>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($item->user_id > 0) :
                        print_r($item->user->username)
                    ?>
                    <?php elseif ($item->user_id == -1) : ?>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'System'); ?>
                    <?php endif; ?>
                </td>
                <td>
                    <?php echo htmlspecialchars((string)$item->phone) ?>
                </td>
                <td>
                    <?php if ($item->status == \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_PENDING) : ?>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Pending'); ?>
                    <?php elseif ($item->status == \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_SCHEDULED) : ?>
                        <span class="material-icons">schedule_send</span> Scheduled
                    <?php elseif ($item->status == \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_READ) : ?>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Read'); ?>
                        <?php
                        $createdTimestamp = $item->created_at;
                        $updatedTimestamp = $item->updated_at;
                        $difference = $updatedTimestamp - $createdTimestamp;
                        $hours = floor($difference / 3600);
                        $minutes = floor(($difference % 3600) / 60);
                        $seconds = $difference % 60;
                        echo '<br>';
                        echo $hours . ' h ' . $minutes . ' m ' . $seconds . ' s';
                        ?>
                    <?php elseif ($item->status == \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_DELIVERED) : ?>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Delivered'); ?>
                    <?php elseif ($item->status == \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_IN_PROCESS) : ?>
                        <?php if ($item->mb_id_message == '') : ?>
                            <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'In process'); ?>
                        <?php else : ?>
                            <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Processed. Pending callback.'); ?>
                        <?php endif; ?>
                    <?php elseif ($item->status == \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_FAILED) : ?>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Failed'); ?>
                        &nbsp;&nbsp;<a class="material-icons" style="color: red;" onclick="lhc.revealModal({'url':WWW_DIR_JAVASCRIPT+'fbwhatsapp/error_modal/<?php echo $item->id ?>'})">dangerous</a>

                    <?php elseif ($item->status == \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_PENDING_PROCESS) : ?>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Pending to be processed'); ?>
                    <?php elseif ($item->status == \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_REJECTED) : ?>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Rejected'); ?>
                    <?php elseif ($item->status == \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_SENT) : ?>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Sent'); ?>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($item->scheduled_at > 0) : ?>
                        <span class="text-<?php $item->scheduled_at > time() ? print 'success' : print 'secondary' ?>"><?php echo date('Y-m-d H:i', $item->scheduled_at) ?></span>
                    <?php else : ?>
                        -
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($item->conversation_id != '') : ?>
                        <span class="material-icons" title=" <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Covnersation'); ?> - <?php echo $item->conversation_id ?>">question_answer</span>
                    <?php endif; ?>

                    <?php if ($item->chat_id > 0) : ?>
                        <?php /* <a ng-non-bindable href="#!#Fchat-id-<?php echo $item->chat_id?>" class="action-image material-icons" data-title="<?php echo htmlspecialchars(is_object($item->chat) ? $item->chat->nick : $item->phone,ENT_QUOTES);?>" onclick="lhinst.startChatNewWindow('<?php echo $item->chat_id;?>',$(this).attr('data-title'))" title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/pendingchats','Open in a new window');?>"><span class="material-icons">open_in_new</span><?php echo htmlspecialchars($item->chat_id)?></a> */ ?>
                        <a target="_blank" href="<?php echo erLhcoreClassDesign::baseurl('front/default') ?>/(cid)/<?php echo $item->chat_id ?>/#!#chat-id-<?php echo $item->chat_id ?>"><span class="material-icons">open_in_new</span><?php echo $item->chat_id ?></a>
                    <?php endif; ?>

                </td>
                <td>
                    <?php if ($item->can_delete) : ?>
                        <a class="csfr-required csfr-post material-icons text-danger" data-trans="delete_confirm" title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Delete message'); ?>" href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsapp/deletemessage') ?>/<?php echo htmlspecialchars($item->id) ?>">delete</a>
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
    // Activar tooltips de Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>