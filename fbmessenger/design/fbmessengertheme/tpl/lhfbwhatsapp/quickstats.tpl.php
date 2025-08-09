<?php
$modalHeaderClass = 'pt-1 pb-1 ps-2 pe-2';
$modalHeaderTitle = erTranslationClassLhTranslation::getInstance()->getTranslation('chat/lists/search_panel','Quick stats');
$modalSize = 'ml';
$modalBodyClass = 'p-1';
$appendPrintExportURL = '';
$engagement = 0;

$rejected = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::getCount(['filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_REJECTED]]);
$failed = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::getCount(['filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_FAILED]]);
$sent = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::getCount(['filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_SENT]]);
$read = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::getCount(['filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_READ]]);
$delivered = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::getCount(['filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_DELIVERED]]);
$generated_conversations = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::getCount(['filtergt' => ['chat_id' => 0]]);
$suma = $rejected + $failed + $sent + $read + $delivered;

if ($suma > 0) {
    $engagement = round(($read / $suma) * 100, 2);
} else {
    $engagement = 0;
}

?>
<?php include(erLhcoreClassDesign::designtpl('lhkernel/modal_header.tpl.php'));?>
<div class="modal-body">
    <div class="row">

        <div class="col-6">
            <div class="form-group">
                <h6><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger','Total messages')?></h6>
                <?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::getCount($filter); ?>
            </div>
        </div>

        <?php foreach (\LiveHelperChatExtension\fbmessenger\providers\FBMessengerWhatsAppMailingValidator::getStatus()  as $statVariation) : ?>
        <div class="col-6">
            <div class="form-group">
                <h6><?php echo htmlspecialchars($statVariation->name)?></h6>
               <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsapp/messages_stats') ?>/?id=<?php echo $statVariation->id ?>">
               <?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::getCount(array_merge_recursive($filter,['filter' => ['status' => $statVariation->id]])); ?>
            </a>
            </div>
        </div>
        
        <?php endforeach; ?>
        <div class="col-6">
            <div class="form-group">
                <h6><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger','Engagement')?></h6>
                <?php echo $engagement.'%' ?>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <h6><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger','Generated conversations')?></h6>
                <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsapp/messages_stats') ?>/?id=9"><?php echo $generated_conversations ?>
            </div>
        </div>

    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('system/buttons','Close')?></button>
</div>
<?php include(erLhcoreClassDesign::designtpl('lhkernel/modal_footer.tpl.php'));?>