<table cellpadding="0" cellspacing="0" class="table table-sm" width="100%" ng-non-bindable>
    <thead>
        <tr>
            <th width="1%"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'ID'); ?></th>
            <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Business Account'); ?></th>
            <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Campaign'); ?></th>
            <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Type'); ?></th>
            <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Department'); ?></th>
            <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Date'); ?></th>
            <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Template'); ?></th>
            <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Iniciación'); ?></th>
            <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'User'); ?></th>
            <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Phone'); ?></th>
            <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Send status'); ?></th>
            <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Scheduled at'); ?></th>
            <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Chat ID'); ?></th>
            <th width="1%"></th>
        </tr>
    </thead>
    </tr>
    </thead>
    <tbody>
        <?php foreach ($messages  as $message) : ?>
            <tr>
                <td>
                    <?php echo htmlspecialchars($message->id) ?>
                    <a class="material-icons" onclick="lhc.revealModal({'url':WWW_DIR_JAVASCRIPT+'fbwhatsapp/rawjson/<?php echo $message->id ?>'})">info_outline</a>
                </td>
                <td><?php print_r($message->phone) ?></td>
                <td>
                    <?php if ($item->campaign_id > 0) : ?>
                        <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaignrecipient') ?>/(campaign)/<?php echo htmlspecialchars($message->campaign_id) ?>"><?php echo htmlspecialchars((string)$message->campaign) ?></a>
                    <?php else : ?>
                        <!-- Aquí puedes agregar lo que desees mostrar cuando campaign_id es 0 o menor -->
                        Envío simple
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($message->private == LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::LIST_PUBLIC) : ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;<span class="material-icons">public</span>
                    <?php else : ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;<span class="material-icons">vpn_lock</span>
                    <?php endif; ?>
                </td>
                <td><?php print_r($message->department->name) ?></td>
                <td><?php print_r($message->created_at) ?></td>
                <td>
                    <?php echo htmlspecialchars((string)$message->template) ?>
                    <?php echo htmlspecialchars($message->id) ?> <a class="material-icons" onclick="lhc.revealModal({'url':WWW_DIR_JAVASCRIPT+'fbwhatsapp/messageview/<?php echo $message->id ?>'})">info_outline</a>
                </td>

                <td>
                    <?php if ($message->initiation == \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::INIT_US) : ?>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Nosotros'); ?>
                    <?php else : ?>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Usuario'); ?>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($message->user_id > 0) :
                        print_r($message->user->username)
                    ?>
                    <?php elseif ($message->user_id == -1) : ?>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'System'); ?>
                    <?php endif; ?>
                </td>
                <td>
                    <?php echo htmlspecialchars((string)$message->phone) ?>
                </td>
                <td>
                    <?php if ($message->status == \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_PENDING) : ?>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Pending'); ?>
                    <?php elseif ($message->status == \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_SCHEDULED) : ?>
                        <span class="material-icons">schedule_send</span> Scheduled
                    <?php elseif ($message->status == \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_READ) : ?>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Read'); ?>
                        <?php
                        $createdTimestamp = $message->created_at;
                        $updatedTimestamp = $message->updated_at;
                        $difference = $updatedTimestamp - $createdTimestamp;
                        $hours = floor($difference / 3600);
                        $minutes = floor(($difference % 3600) / 60);
                        $seconds = $difference % 60;
                        echo '<br>';
                        echo $hours . ' h ' . $minutes . ' m ' . $seconds . ' s';
                        ?>
                    <?php elseif ($message->status == \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_DELIVERED) : ?>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Delivered'); ?>
                    <?php elseif ($message->status == \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_IN_PROCESS) : ?>
                        <?php if ($message->mb_id_message == '') : ?>
                            <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'In process'); ?>
                        <?php else : ?>
                            <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Processed. Pending callback.'); ?>
                        <?php endif; ?>
                    <?php elseif ($message->status == \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_FAILED) : ?>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Failed'); ?>
                    <?php elseif ($message->status == \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_PENDING_PROCESS) : ?>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Pending to be processed'); ?>
                    <?php elseif ($message->status == \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_REJECTED) : ?>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Rejected'); ?>
                    <?php elseif ($message->status == \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_SENT) : ?>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Sent'); ?>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($message->scheduled_at > 0) : ?>
                        <span class="text-<?php $message->scheduled_at > time() ? print 'success' : print 'secondary' ?>"><?php echo date('Y-m-d H:i', $message->scheduled_at) ?></span>
                    <?php else : ?>
                        -
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($message->conversation_id != '') : ?>
                        <span class="material-icons" title=" <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Covnersation'); ?> - <?php echo $message->conversation_id ?>">question_answer</span>
                    <?php endif; ?>

                    <?php if ($message->chat_id > 0) : ?>
                        <?php /* <a ng-non-bindable href="#!#Fchat-id-<?php echo $message->chat_id?>" class="action-image material-icons" data-title="<?php echo htmlspecialchars(is_object($message->chat) ? $message->chat->nick : $message->phone,ENT_QUOTES);?>" onclick="lhinst.startChatNewWindow('<?php echo $message->chat_id;?>',$(this).attr('data-title'))" title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/pendingchats','Open in a new window');?>"><span class="material-icons">open_in_new</span><?php echo htmlspecialchars($message->chat_id)?></a> */ ?>
                        <a target="_blank" href="<?php echo erLhcoreClassDesign::baseurl('front/default') ?>/(cid)/<?php echo $message->chat_id ?>/#!#chat-id-<?php echo $message->chat_id ?>"><span class="material-icons">open_in_new</span><?php echo $message->chat_id ?></a>
                    <?php endif; ?>

                </td>
                <td>
                    <?php if ($message->can_delete) : ?>
                        <a class="csfr-required csfr-post material-icons text-danger" data-trans="delete_confirm" title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Delete message'); ?>" href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsapp/deletemessage') ?>/<?php echo htmlspecialchars($message->id) ?>">delete</a>
                    <?php endif; ?>
                </td>

                <!-- Agrega más celdas según tus necesidades -->
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>