<style>
    .recuadro-container {
        display: flex;
        margin-bottom: 20px;
    }

    /* Estilo para la clase recuadro */
    .recuadro,
    .recuadro-button {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        padding: 20px;
        margin-bottom: 20px;
        transition: all 0.3s ease;
        text-align: left;
        width: 100%;
    }

    .recuadro:hover,
    .recuadro-button:hover {
        background-color: #e9ecef;
        transform: translateY(-5px);
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
        border-color: #ced4da;
        cursor: pointer;
    }

    .recuadro p,
    .recuadro h1,
    .recuadro-button p,
    .recuadro-button h1 {
        margin: 0;
    }

    /* Estilos para los números */
    .recuadro h1,
    .recuadro-button h1 {
        font-size: 32px;
        color: #007bff;
    }

    /* Eliminar estilo de borde y fondo predeterminado de botones */
    .recuadro-button {
        background: none;
        border: none;
        padding: 0;
    }


    .stats-layout {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
    }

    .stats-left {
        flex: 3;
    }

    .stats-right {
        flex: 1;
    }

    .mini-botones {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .mini-recuadro {
        background-color: #e8f5e9;
        border: 1px solid #a5d6a7;
        border-radius: 6px;
        padding: 6px 10px;
        font-size: 0.9em;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .mini-recuadro:hover {
        background-color: #d7f2db;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        transform: translateY(-2px);
    }

    .mini-recuadro strong {
        color: #2e7d32;
    }
</style>
<h1><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Statistics'); ?></h1>

<?php if (isset($updated)) : $msg = erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Updated'); ?>
    <?php include(erLhcoreClassDesign::designtpl('lhkernel/alert_success.tpl.php')); ?>
<?php endif; ?>

<?php if (isset($errors)) : ?>
    <?php include(erLhcoreClassDesign::designtpl('lhkernel/validation_error.tpl.php')); ?>
<?php endif; ?>

<?php if (!empty($clicksPorBoton)) {
    arsort($clicksPorBoton);
}
?>

<?php include(erLhcoreClassDesign::designtpl('lhkernel/csfr_token.tpl.php')); ?>

<?php
// Conteos originales
$failedCount    = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_FAILED, 'campaign_id' => $item->id]]);
$sentCount      = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_SENT, 'campaign_id' => $item->id]]);
$readCount      = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_READ, 'campaign_id' => $item->id]]);
$rejectedCount  = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_REJECTED, 'campaign_id' => $item->id]]);
$deliveredCount = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_DELIVERED, 'campaign_id' => $item->id]]);
$pendingCount   = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_PENDING, 'campaign_id' => $item->id]]);

// Total conversaciones (todas las statuses relevantes)
$totalConversations = $failedCount + $sentCount + $readCount + $rejectedCount + $deliveredCount + $pendingCount;

// 📌 Mensajes enviados = leídos + entregados + enviados
$mensajesEnviados = $readCount + $deliveredCount + $sentCount;

// 📌 Tasa de envío (%)
$tasaEnvio = $totalConversations > 0 ? round(($mensajesEnviados / $totalConversations) * 100, 2) : 0;

// 📌 Tasa de respuesta (conversaciones generadas) en %
$respuestasCount = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount([
    'filter' => ['campaign_id' => $item->id],
    'filtergt' => ['conversation_id' => 0]
]);
$tasaRespuesta = $totalConversations > 0 ? round(($respuestasCount / $totalConversations) * 100, 2) : 0;

// 📌 Tasa de rebote = rechazados + pendientes en %
$tasaRebote = $totalConversations > 0 ? round((($rejectedCount + $pendingCount) / $totalConversations) * 100, 2) : 0;
?>



<strong>
    <p><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Information'); ?></p>
</strong>


<div class="stats-layout">
    <div class="stats-left">
        <div class="recuadro-container">
            <div class="recuadro">
                <p><strong>Mensajes enviados</strong></p>
                <h1><?php echo $mensajesEnviados; ?></h1>
            </div>
            <div class="recuadro">
                <p><strong>Tasa de efectividad (%)</strong></p>
                <h1><?php echo $tasaEnvio; ?>%</h1>
            </div>
            <div class="recuadro">
                <p><strong>Tasa de respuesta (%)</strong></p>
                <h1><?php echo $tasaRespuesta; ?>%</h1>
            </div>
            <div class="recuadro">
                <p><strong>Tasa de rebote (%)</strong></p>
                <h1><?php echo $tasaRebote; ?>%</h1>
            </div>
        </div>
    </div>

</div>

<div role="tabpanel" class="tab-pane" id="statistic">
    <div class="row">
        <div class="col-md-6">
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
            <li><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Total recipients'); ?> - <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaignrecipient') ?>/(campaign)/<?php echo $item->id ?>"><?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['campaign_id' => $item->id]]) ?></a></strong></li>
            <br><br>
            <strong>
                <p><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Statistic'); ?></p>
            </strong>
            <ul>

                <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Pending'); ?> - <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaignrecipient') ?>/(campaign)/<?php echo $item->id ?>/(status)/<?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_PENDING ?>"><?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_PENDING, 'campaign_id' => $item->id]]) ?></a></li>
                <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'In progress'); ?> - <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaignrecipient') ?>/(campaign)/<?php echo $item->id ?>/(status)/<?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_IN_PROCESS ?>"><?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_IN_PROCESS, 'campaign_id' => $item->id]]) ?></a></li>
                <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Failed'); ?> - <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaignrecipient') ?>/(campaign)/<?php echo $item->id ?>/(status)/<?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_FAILED ?>"><?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_FAILED, 'campaign_id' => $item->id]]) ?></a></li>
                <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Rejected'); ?> - <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaignrecipient') ?>/(campaign)/<?php echo $item->id ?>/(status)/<?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_REJECTED ?>"><?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_REJECTED, 'campaign_id' => $item->id]]) ?></a></li>
                <!-- <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Read'); ?> - <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaignrecipient') ?>/(campaign)/<?php echo $item->id ?>/(status)/<?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_READ ?>"><?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_READ, 'campaign_id' => $item->id]]) ?></a></li> -->
                <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Scheduled'); ?> - <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaignrecipient') ?>/(campaign)/<?php echo $item->id ?>/(status)/<?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_SCHEDULED ?>"><?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_SCHEDULED, 'campaign_id' => $item->id]]) ?></a></li>
                <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Delivered'); ?> - <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaignrecipient') ?>/(campaign)/<?php echo $item->id ?>/(status)/<?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_DELIVERED ?>"><?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_DELIVERED, 'campaign_id' => $item->id]]) ?></a></li>
                <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Pending process'); ?> - <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaignrecipient') ?>/(campaign)/<?php echo $item->id ?>/(status)/<?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_PENDING_PROCESS ?>"><?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_PENDING_PROCESS, 'campaign_id' => $item->id]]) ?></a></li>
                <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Sent'); ?> - <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaignrecipient') ?>/(campaign)/<?php echo $item->id ?>/(status)/<?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_SENT ?>"><?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_SENT, 'campaign_id' => $item->id]]) ?></a></li>
                <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Number of recipients who opened an e-mail'); ?> - <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaignrecipient') ?>/(campaign)/<?php echo $item->id ?>/(opened)/1"><?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['campaign_id' => $item->id], 'filtergt' => ['opened_at' => 0]]) ?></a></li>

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
                <a class="btn btn-primary" href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaign') ?>"><span class="material-icons">reply</span>Regresar al panel</a>
            </ul>
        </div>
        <div class="col-md-6">
            <div class="stats-right">
                <?php if (!empty($clicksPorBoton)) : ?>
                    <h4 style="margin-bottom: 10px; color: #555;">
                        📊 Botones de la plantilla (ranking de clics)
                    </h4>
                    <div class="mini-botones">
                        <?php foreach ($clicksPorBoton as $boton => $cantidad) : ?>
                            <div class="mini-recuadro">
                                <span><?php echo htmlspecialchars($boton); ?></span>
                                <strong><?php echo $cantidad; ?></strong>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <br><br>
            <h3>⏱ Métricas de lectura</h3>
            <div class="mini-botones-grid">
                <div class="mini-recuadro"><span>Promedio de lectura</span><strong><?php echo $promedioLectura; ?></strong></div>
                <div class="mini-recuadro"><span>Lectura más rápida</span><strong><?php echo $lecturaRapida; ?></strong></div>
                <div class="mini-recuadro"><span>Lectura más lenta</span><strong><?php echo $lecturaLenta; ?></strong></div>
                <div class="mini-recuadro"><span>Día con mayor interacción</span><strong><?php echo $diaMayorInteraccion; ?></strong></div>
                <div class="mini-recuadro"><span>Día con menor interacción</span><strong><?php echo $diaMenorInteraccion; ?></strong></div>
            </div>

        </div>
    </div>
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