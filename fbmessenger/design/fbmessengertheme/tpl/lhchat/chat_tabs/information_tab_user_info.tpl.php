<?php
$contacts = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppContact::getList();
$phonesArray = [];
foreach ($contacts as $contact) {
	$phonesArray[] = $contact->phone;
}

$items = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppContact::getList(['filter' => ['phone' => $chat->phone]]);


?>
<?php foreach ($items as $item) {
	$id_telefono = $item->id;
} ?>

<?php include(erLhcoreClassDesign::designtpl('lhchat/chat_tabs/information/information_top.tpl.php'));?>

<div>
    <?php include(erLhcoreClassDesign::designtpl('lhchat/chat_tabs/actions/actions_order.tpl.php'));?>
    <?php include(erLhcoreClassDesign::designtpl('lhchat/chat_tabs/actions/actions_order_extension_multiinclude.tpl.php'));?>

    <?php foreach ($orderChatButtons as $buttonData) : ?>
        <?php if ($buttonData['enabled'] == true) : ?>
            <?php if ($buttonData['item'] == 'print_archive') : ?>
                <?php include(erLhcoreClassDesign::designtpl('lhchat/chat_tabs/actions/print_archive.tpl.php'));?>
            <?php elseif ($buttonData['item'] == 'mail_archive') : ?>
                <?php include(erLhcoreClassDesign::designtpl('lhchat/chat_tabs/actions/mail_archive.tpl.php'));?>
            <?php endif; ?>
        <?php endif; ?>
    <?php endforeach; ?>
    
    <?php include(erLhcoreClassDesign::designtpl('lhchat/chat_tabs/chat_actions_extension_multiinclude.tpl.php'));?>
</div>

<?php include(erLhcoreClassDesign::designtpl('lhchat/chat_tabs/information_rows/information_order.tpl.php'));?>
<?php include(erLhcoreClassDesign::designtpl('lhchat/chat_tabs/information_rows/information_order_extension_multiinclude.tpl.php'));?>

<table class="table table-sm table-borderless">
<?php foreach ($orderInformation as $buttonData) : ?>
    <?php if ($buttonData['enabled'] == true) : ?>
        <?php if ($buttonData['item'] == 'chat') : ?>
            <?php include(erLhcoreClassDesign::designtpl('lhchat/chat_tabs/above_department_extension_multiinclude.tpl.php'));?>
            <?php include(erLhcoreClassDesign::designtpl('lhchat/chat_tabs/information_rows/chat.tpl.php'));?>
        <?php elseif ($buttonData['item'] == 'product') : ?>
            <?php include(erLhcoreClassDesign::designtpl('lhchat/chat_tabs/information_rows/product.tpl.php'));?>
        <?php elseif ($buttonData['item'] == 'uagent') : ?>
            <?php include(erLhcoreClassDesign::designtpl('lhchat/chat_tabs/information_rows/uagent.tpl.php'));?>
        <?php elseif ($buttonData['item'] == 'voice_call') : ?>
            <?php include(erLhcoreClassDesign::designtpl('lhchat/chat_tabs/information_rows/voice_call.tpl.php'));?>
        <?php elseif ($buttonData['item'] == 'subject') : ?>
            <?php include(erLhcoreClassDesign::designtpl('lhchat/chat_tabs/information_rows/subject.tpl.php'));?>
        <?php elseif ($buttonData['item'] == 'phone') : ?>
            <?php include(erLhcoreClassDesign::designtpl('lhchat/chat_tabs/after_phone_extension_multiinclude.tpl.php'));?>
        <?php elseif ($buttonData['item'] == 'additional_data') : ?>
            <?php include(erLhcoreClassDesign::designtpl('lhchat/chat_tabs/information_rows/additional_data.tpl.php'));?>
         <?php elseif ($buttonData['item'] == 'chat_duration') : ?>
            <?php include(erLhcoreClassDesign::designtpl('lhchat/chat_tabs/information_rows/chat_duration.tpl.php'));?>
        <?php elseif ($buttonData['item'] == 'chat_owner') : ?>
            <?php include(erLhcoreClassDesign::designtpl('lhchat/chat_tabs/information_rows/chat_owner.tpl.php'));?>
        <?php else : ?>
            <?php include(erLhcoreClassDesign::designtpl('lhchat/chat_tabs/information_rows/extension_information_row_multiinclude.tpl.php'));?>
        <?php endif;?>
    <?php endif; ?>
<?php endforeach; ?>
</table>

<td>

<button class="btn btn-success" onclick="return lhc.revealModal({
                                                                'url': '<?php echo erLhcoreClassDesign::baseurl('fbwhatsapp/simple_send'); ?>?phone=<?php echo urlencode($chat->phone); ?>'
                                                                })">
    <span class="material-icons">Send</span>
    <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Send whatsapp template'); ?>
</button>
<br><br>

<?php if (!in_array($chat->phone, $phonesArray)) : ?>
    <button class="btn btn-success" href="#" onclick="return lhc.revealModal({'title' : 'Import', 'height':350, backdrop:true, 'url':'<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/newmailingrecipient') ?>/?contact=<?php echo $chat->phone ?>'})">
        <span class="material-icons">add</span><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Add manual contact'); ?>
    </button><br><br>
<?php else : ?>
    <button class="btn btn-success" href="#" onclick="return lhc.revealModal({'title' : 'Import', 'height':350, backdrop:true, 'url':'<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/editmailingrecipient') ?>/?id=<?php echo $id_telefono ?>'})">
        <span class="material-icons">edit</span><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Edit'); ?>
    </button>
    <?php
    $contacto = LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppContact::getList(['filter' => ['phone' => $chat->phone]]);

    foreach ($contacto as $i) {
        $id_contacto = $i->id;
        $listas = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppContactList::getList();
        $relaciones = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppContactListContact::getList(['filter' => ['contact_id' => $id_contacto]]);
        if (!empty($relaciones)) {
            foreach ($listas as $lista) {
                foreach ($relaciones as $relacion) {
                    if ($relacion->contact_list_id == $lista->id) {
                        echo '<strong>';
                        echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Contact list').': ';
                        echo '</strong>';
                        echo '<mark>';
                        echo $lista->name;
                        echo '</mark>';
                    }
                }
            }
        }else{
            echo '<mark>';
            print_r(erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Contact without list'));
            echo '</mark>';
        }
    }

    ?>
<?php endif ?>
<hr style="border: none; height: 2px; background-color: #000; opacity: 1;">

</td>
