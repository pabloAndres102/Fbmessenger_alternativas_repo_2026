<style>
     .recuadro-container {
        display: flex;
        margin-bottom: 20px;
    }

    /* Estilo para la clase recuadro */
    .recuadro {
        flex: 1;
        width: 100%;
        height: 100px;
        background-color: #f0f0f0;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        text-align: center;
        margin-right: 20px;
        }
</style>
<h1><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Statistics'); ?></h1>

<?php if (isset($updated)) : $msg = erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Updated'); ?>
    <?php include(erLhcoreClassDesign::designtpl('lhkernel/alert_success.tpl.php')); ?>
<?php endif; ?>

<?php if (isset($errors)) : ?>
    <?php include(erLhcoreClassDesign::designtpl('lhkernel/validation_error.tpl.php')); ?>
<?php endif; ?>


<?php include(erLhcoreClassDesign::designtpl('lhkernel/csfr_token.tpl.php')); ?>





<strong>
    <p><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Information'); ?></p>
</strong>

<div class="recuadro-container">
    <div class="recuadro"> <!-- Recuadro 1 -->
        <p><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Sent conversations'); ?></strong></p>
        <?php
        $failedCount = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_FAILED, 'campaign_id' => $item->id]]);

        $sentCount = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' =>  ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_SENT, 'campaign_id' => $item->id]]);

        $readCount = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_READ, 'campaign_id' => $item->id]]);

        $rejectedCount = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_REJECTED, 'campaign_id' => $item->id]]);

        $deliveredCount = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_DELIVERED, 'campaign_id' => $item->id]]);

        $totalConversations = $failedCount + $sentCount + $readCount + $rejectedCount + $deliveredCount;
        if ($totalConversations > 0) {
            $engagement = round(($readCount / $totalConversations) * 100, 2);
        } else {
            $engagement = 0;
        }

        ?>
        <h1><?php echo $totalConversations; ?></h1>
    </div>
    <div class="recuadro"> <!-- Recuadro 4 -->
        <p><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Total read'); ?></strong></p>
        <h1><?php print_r($readCount); ?></h1>
    </div>
    <div class="recuadro"> <!-- Recuadro 4 -->
        <p><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Engagement'); ?></strong></p>
        <h1><?php print_r($engagement); ?></h1>
    </div>
    <div class="recuadro"> <!-- Recuadro 4 -->
        <p><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Generated conversations'); ?></strong></p>
        <h1><?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['campaign_id' => $item->id], 'filtergt' => ['conversation_id' => 0]]) ?></h1>
    </div>
</div>


<div role="tabpanel" class="tab-pane" id="statistic">
    <li><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Owner'); ?></strong> - <?php echo htmlspecialchars((string)$item->user) ?></li>
    <li><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Campaign'); ?></strong> - <?php echo htmlspecialchars((string)$item->name) ?></li>
    <li><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Template'); ?></strong> - <?php echo htmlspecialchars((string)$item->template) ?></li>
    <li><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Date send'); ?></strong> - <?php echo date('Y-m-d H:i', $item->starts_at) ?></li>
    <li><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Phone sender'); ?></strong> -
        <?php foreach ($phones as $phone) : ?>
            <?php echo $phone['display_phone_number'] ?>
        <?php endforeach; ?>
    </li>
    <li><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Department'); ?></strong> - <?php echo htmlspecialchars((string)$department) ?></li>
    <li><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Status'); ?></strong> - <?php if ($item->status == LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaign::STATUS_PENDING) : ?>
            <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Pending'); ?>
        <?php elseif ($item->status == LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaign::STATUS_IN_PROGRESS) : ?>
            <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'In progress'); ?>
        <?php elseif ($item->status == LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaign::STATUS_FINISHED) : ?>
            <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Finished'); ?>
        <?php endif; ?>
        <br><br>
        <strong>
            <p><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Statistic'); ?></p>
        </strong>
        <ul>
            <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Total recipients'); ?> - <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaignrecipient') ?>/(campaign)/<?php echo $item->id ?>"><?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['campaign_id' => $item->id]]) ?></a></li>
            <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Pending'); ?> - <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaignrecipient') ?>/(campaign)/<?php echo $item->id ?>/(status)/<?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_PENDING ?>"><?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_PENDING, 'campaign_id' => $item->id]]) ?></a></li>
            <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'In progress'); ?> - <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaignrecipient') ?>/(campaign)/<?php echo $item->id ?>/(status)/<?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_IN_PROCESS ?>"><?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_IN_PROCESS, 'campaign_id' => $item->id]]) ?></a></li>
            <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Failed'); ?> - <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaignrecipient') ?>/(campaign)/<?php echo $item->id ?>/(status)/<?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_FAILED ?>"><?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_FAILED, 'campaign_id' => $item->id]]) ?></a></li>
            <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Rejected'); ?> - <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaignrecipient') ?>/(campaign)/<?php echo $item->id ?>/(status)/<?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_REJECTED ?>"><?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_REJECTED, 'campaign_id' => $item->id]]) ?></a></li>
            <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Read'); ?> - <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaignrecipient') ?>/(campaign)/<?php echo $item->id ?>/(status)/<?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_READ ?>"><?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_READ, 'campaign_id' => $item->id]]) ?></a></li>
            <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Scheduled'); ?> - <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaignrecipient') ?>/(campaign)/<?php echo $item->id ?>/(status)/<?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_SCHEDULED ?>"><?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_SCHEDULED, 'campaign_id' => $item->id]]) ?></a></li>
            <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Delivered'); ?> - <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaignrecipient') ?>/(campaign)/<?php echo $item->id ?>/(status)/<?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_DELIVERED ?>"><?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_DELIVERED, 'campaign_id' => $item->id]]) ?></a></li>
            <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Pending process'); ?> - <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaignrecipient') ?>/(campaign)/<?php echo $item->id ?>/(status)/<?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_PENDING_PROCESS ?>"><?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_PENDING_PROCESS, 'campaign_id' => $item->id]]) ?></a></li>
            <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Sent'); ?> - <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaignrecipient') ?>/(campaign)/<?php echo $item->id ?>/(status)/<?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_SENT ?>"><?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_SENT, 'campaign_id' => $item->id]]) ?></a></li>
            <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger','Number of recipients who opened an e-mail');?> - <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaignrecipient')?>/(campaign)/<?php echo $item->id?>/(opened)/1"><?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['campaign_id' => $item->id], 'filtergt' => ['opened_at' => 0]])?></a></li>

            <li>
                <form action="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/editcampaign') ?>/<?php echo $item->id ?>" class="custom-form" method="post">
                    <div class="row">
                        <div class="col-md-8"> <!-- Ajusta el tamaño de la columna según tus necesidades -->
                            <div class="input-group">
                                <input class="form-control" name="email" type="email" style="max-width: 300px;"> <!-- Ajusta el ancho máximo según tus necesidades -->
                                <button class="btn btn-success" type="submit">
                                    <span class="material-icons">send</span>
                                    <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Send information'); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </li>
            <br>
            <a class="btn btn-primary" href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaign')?>"><span class="material-icons">reply</span>Regresar al panel</a>

        </ul>
</div>
</div>




<!-- <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Obtiene la URL actual
        var currentUrl = window.location.href;

        // Verifica si la URL contiene el parámetro "?tab=statistic"
        if (currentUrl.indexOf("?tab=statistic") !== -1) {
            // Cambia el título a "Statistics"
            document.querySelector('h1').innerText = "<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Statistics'); ?>";

            // Oculta la pestaña "Main"
            var mainTab = document.querySelector('a[href="#settings"]');
            if (mainTab) {
                mainTab.parentElement.style.display = 'none';
            }

            // Selecciona la pestaña "statistic" y muestra su contenido
            var statisticTab = document.querySelector('a[href="#statistic"]');
            if (statisticTab) {
                statisticTab.click(); // Simula un clic en la pestaña "statistic"
            }
        }
    });
</script> -->
<script>
    //     document.addEventListener('DOMContentLoaded', function() {
    //         // Obtiene una referencia al input con el nombre "name"

    //         var departmentSelect = document.querySelector('select[name="dep_id"]');
    //         var privateCheckbox = document.querySelector('input[name="private"]');
    //         var startDateTimeInput = document.getElementById('startDateTime');
    //         var phoneSelect = document.getElementById('id_phone_sender_id');
    //         var businessAccountSelect = document.querySelector('select[name="business_account_id"]');
    //         var templateSelect = document.querySelector('select[name="template"]');

    //         // Deshabilita el campo para hacerlo de solo lectura

    //         departmentSelect.setAttribute('disabled', 'disabled');
    //         privateCheckbox.setAttribute('disabled', 'disabled');
    //         startDateTimeInput.setAttribute('disabled', 'disabled');
    //         phoneSelect.setAttribute('disabled', 'disabled');
    //         businessAccountSelect.setAttribute('disabled', 'disabled');
    //         templateSelect.setAttribute('disabled', 'disabled');
    //     });
    // 
</script>