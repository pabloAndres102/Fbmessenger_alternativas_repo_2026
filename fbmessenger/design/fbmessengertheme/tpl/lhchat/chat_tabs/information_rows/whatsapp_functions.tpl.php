<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

<td style="vertical-align: top;">

    <div class="panel panel-default">
        <div class="panel-heading">
            <h6>
                <img class="me-1" title="Facebook WhatsApp"
                    src="<?php echo erLhcoreClassDesign::design('images/social/whatsapp-ico.png'); ?>"
                    style="height:18px; vertical-align:middle;">
                <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'WhatsApp Functions'); ?>
            </h6>
        </div>


        <div class="panel-body">

            <?php if (!in_array($chat->phone, $phonesArray)) : ?>

                <!-- Botones en línea -->
                <div class="d-flex gap-2 mb-2">
                    <button class="btn btn-secondary btn-sm flex-fill"
                        onclick="return lhc.revealModal({
                                'url': '<?php echo erLhcoreClassDesign::baseurl('fbwhatsapp/simple_send'); ?>?phone=<?php echo urlencode($chat->phone); ?>'
                            })">
                        <span class="material-icons">send</span>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Send template'); ?>
                    </button>

                    <button class="btn btn-secondary btn-sm flex-fill"
                        onclick="return lhc.revealModal({
                                'title' : 'Import', 
                                'height':350, 
                                backdrop:true, 
                                'url':'<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/newmailingrecipient') ?>/?contact=<?php echo $chat->phone ?>'
                            })">
                        <span class="material-icons">add</span>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Add contact'); ?>
                    </button>
                </div>

            <?php else : ?>

                <!-- Botones en línea -->
                <div class="d-flex gap-2 mb-2">
                    <button class="btn btn-secondary btn-sm flex-fill"
                        onclick="return lhc.revealModal({
                                'url': '<?php echo erLhcoreClassDesign::baseurl('fbwhatsapp/simple_send'); ?>?phone=<?php echo urlencode($chat->phone); ?>'
                            })">
                        <span class="material-icons">send</span>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Send template'); ?>
                    </button>



                    <button class="btn btn-secondary btn-sm flex-fill"
                        onclick="return lhc.revealModal({
                                'title' : 'Import', 
                                'height':350, 
                                backdrop:true, 
                                'url':'<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/editmailingrecipient') ?>/?id=<?php echo $id_telefono ?>'
                            })">
                        <span class="material-icons">edit</span>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Edit'); ?>
                    </button>
                </div>

                <!-- Título listas de contacto -->
                <div class="mt-3 mb-1 fw-bold">
                    <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Contact lists'); ?>:
                </div>

                <!-- Contacto en lista -->
                <div class="small">
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
                                        echo '<div style="font-size:1rem; margin-bottom:2px;">- ' . htmlspecialchars($lista->name) . '</div>';
                                    }
                                }
                            }
                        } else {
                            echo '<div style="font-size:1rem; margin-bottom:2px;">- ' . erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Contact without list') . '</div>';
                        }
                    }
                    ?>
                </div>

            <?php endif; ?>
            <div class="panel-heading p-2">
                <div class="d-flex align-items-center gap-2">
                    <span class="material-icons" style="font-size:18px;">sms</span>
                    <h6 class="m-0 fw-bold">
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'SMS'); ?>
                    </h6>
                </div>

                <button class="btn btn-secondary btn-sm d-flex align-items-center gap-1 mt-1 flex-fill"
                    title="Enviar SMS de prueba"
                    onclick="return lhc.revealModal({
        'url': '<?php echo erLhcoreClassDesign::baseurl('fbmessenger/modal_sms'); ?>'
    })">
                    <span class="material-icons">sms</span>
                    <span>Enviar SMS</span>
                </button>

            </div>




        </div>
    </div>

</td>