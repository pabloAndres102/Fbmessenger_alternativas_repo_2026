<style>
    .recuadro {
        background: #000000ff;
        border-radius: 12px;
        padding: 0;
        margin-bottom: 0;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease-in-out;
    }

    .titulo-seccion {
        font-weight: bold;
        /* el strong */
        margin: 10px 0 5px 0;
        /* espacio arriba/abajo */
        text-align: left;
        /* alinea con los <li> */
    }

    .col-md-6 ul {
        list-style: none;
        /* quita viñetas */
        padding-left: 0;
        /* alinea con el título */
        margin: 0;
    }

    .col-md-6 li {
        margin: 2px 0;
    }

    .recuadro li {
        list-style: none;
        /* elimina viñetas */
        margin: 5px 0;
        /* espacio entre filas */
        padding-left: 0;
        /* quita indentación */
        text-align: left;
        /* alinea texto a la izquierda */
    }

    .recuadro h6 {
        text-align: left;
        margin: 10px 0;
        font-weight: bold;
    }

    .recuadro:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }

    .mini-recuadro:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }

    /* Opcional: títulos más visibles */
    .recuadro h6 {
        font-weight: bold;
        margin-bottom: 12px;
        color: #333;
    }

    .info-stats-two-columns {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        margin-top: 20px;
    }

    p {
        margin: 0;
        padding: 0;
    }

    /* ======== Encabezados ======== */
    .main-title {
        font-size: 26px;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .section-title {
        font-size: 20px;
        font-weight: bold;
        margin-top: 20px;
        margin-bottom: 10px;
    }

    /* ======== Información general ======== */
    .info-general {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px;
        margin-bottom: 30px;
    }

    .info-general ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .info-general li {
        margin-bottom: 6px;
        font-size: 14px;
    }

    .info-general li strong {
        font-weight: bold;
        margin-right: 5px;
    }

    /* ======== Métricas (recuadros azules) ======== */
    .recuadro-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 20px;
        margin: 20px 0;
    }

    .mini-recuadro-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 20px;
        margin: 20px 0;
    }

    .recuadro {
        background: #f5f8ff;
        border: 1px solid #d6e4ff;
        padding: 20px;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .mini-recuadro {
        background: rgba(165, 214, 167, 0.25);
        /* 25% de opacidad */
        border: 1px solid rgba(165, 214, 167, 0.4);
        padding: 20px;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
        backdrop-filter: blur(6px);
        /* efecto vidrio */
    }


    .recuadro h1 {
        font-size: 32px;
        color: #0d47a1;
        margin: 10px 0 0 0;
    }

    .recuadro p {
        font-size: 14px;
        font-weight: bold;
        color: #444;
    }

    /* ======== Mini métricas (verde) ======== */
    .mini-botones-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 12px;
        margin-top: 15px;
    }

    /* ======== Botones ranking ======== */
    .mini-botones {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }


    /* ======== Botón regresar ======== */
    .btn-primary {
        margin-top: 20px;
    }
</style>

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
$tasaRebote = $totalConversations > 0 ? round((($rejectedCount + $pendingCount + $failedCount) / $totalConversations) * 100, 2) : 0;
?>



<div style="display:flex; gap:8px; align-items:center; font-size:14px;">
    <strong>
        <h4><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Statistics'); ?>:</h4>
    </strong>
    <span>|</span>
    <strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Campaign'); ?>:</strong>
    <span><?php echo htmlspecialchars((string)$item->name) ?></span>
</div>

<div class="info-stats-two-columns">

    <!-- Columna 1: Información -->
    <div>

        <div class="col-md-12">
            <div class="recuadro">
                <li><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Owner'); ?></strong> - <?php echo htmlspecialchars((string)$item->user) ?></li>

                <li><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Template'); ?></strong> - <?php echo htmlspecialchars((string)$item->template) ?></li>
                <li><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Date send'); ?></strong> - <?php echo $item->starts_at ?></li>
                <li><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Phone sender'); ?></strong> -
                    <?php foreach ($phones as $phone) : ?>
                        <?php echo $phone['display_phone_number'] ?>
                    <?php endforeach; ?>
                </li>
                <li><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Department'); ?></strong> - <?php echo htmlspecialchars((string)$department) ?></li>
                <li><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Status'); ?></strong> -
                    <?php if ($item->status == LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaign::STATUS_PENDING) : ?>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Pending'); ?>
                    <?php elseif ($item->status == LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaign::STATUS_IN_PROGRESS) : ?>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'In progress'); ?>
                    <?php elseif ($item->status == LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaign::STATUS_FINISHED) : ?>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Finished'); ?>
                    <?php endif; ?>
                </li>
                <li><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Total recipients'); ?></strong> -
                    <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaignrecipient') ?>/(campaign)/<?php echo $item->id ?>">
                        <?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['campaign_id' => $item->id]]) ?>
                    </a>
                </li>
            </div>
        </div>
    </div>

    <!-- Columna 2: Estadísticas -->
    <div class="recuadro">
        <div class="row">

            <!-- Columna 1 -->
            <div class="col-md-6">
                <strong>
                    <h6 class="titulo-seccion"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Estados del mensaje enviado'); ?></h6>
                </strong>
                <ul>
                    <li>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Enviado'); ?> -
                        <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaignrecipient') ?>/(campaign)/<?php echo $item->id ?>/(status)/
                    <?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_SENT ?>">
                            <?php echo ' ' . \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount([
                                'filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_SENT, 'campaign_id' => $item->id]
                            ]) ?>
                        </a>
                    </li>

                    <li>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Entregado'); ?> -
                        <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaignrecipient') ?>/(campaign)/<?php echo $item->id ?>/(status)/
                    <?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_DELIVERED ?>">
                            <?php echo ' ' . \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount([
                                'filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_DELIVERED, 'campaign_id' => $item->id]
                            ]) ?>
                        </a>
                    </li>

                    <li>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Leído'); ?> -
                        <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaignrecipient') ?>/(campaign)/<?php echo $item->id ?>/(status)/
                    <?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_READ ?>">
                            <?php echo ' ' . \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount([
                                'filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_READ, 'campaign_id' => $item->id]
                            ]) ?>
                        </a>
                    </li>
                </ul>

                <strong>
                    <h6 class="titulo-seccion"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Estado de rebote'); ?></h6>
                </strong>
                <ul>
                    <li>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Pendiente'); ?> -
                        <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaignrecipient') ?>/(campaign)/<?php echo $item->id ?>/(status)/
                    <?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_PENDING ?>">
                            <?php echo ' ' . \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount([
                                'filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_PENDING, 'campaign_id' => $item->id]
                            ]) ?>
                        </a>
                    </li>

                    <li>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Rechazado'); ?> -
                        <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaignrecipient') ?>/(campaign)/<?php echo $item->id ?>/(status)/
                    <?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_REJECTED ?>">
                            <?php echo ' ' . \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount([
                                'filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_REJECTED, 'campaign_id' => $item->id]
                            ]) ?>
                        </a>
                    </li>

                    <li>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Falló entrega'); ?> -
                        <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaignrecipient') ?>/(campaign)/<?php echo $item->id ?>/(status)/
                    <?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_FAILED ?>">
                            <?php echo ' ' . \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount([
                                'filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_FAILED, 'campaign_id' => $item->id]
                            ]) ?>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Columna 2 -->
            <div class="col-md-6">
                <strong>
                    <h6 class="titulo-seccion"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Estados de entrega'); ?></h6>
                </strong>
                <ul>
                    <li>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'En progreso'); ?> -
                        <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaignrecipient') ?>/(campaign)/<?php echo $item->id ?>/(status)/
                    <?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_IN_PROCESS ?>">
                            <?php echo ' ' . \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount([
                                'filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_IN_PROCESS, 'campaign_id' => $item->id]
                            ]) ?>
                        </a>
                    </li>

                    <li>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Proceso pendiente'); ?> -
                        <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaignrecipient') ?>/(campaign)/<?php echo $item->id ?>/(status)/
                    <?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_PENDING_PROCESS ?>">
                            <?php echo ' ' . \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount([
                                'filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_PENDING_PROCESS, 'campaign_id' => $item->id]
                            ]) ?>
                        </a>
                    </li>

                    <li>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Envío programado'); ?> -
                        <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaignrecipient') ?>/(campaign)/<?php echo $item->id ?>/(status)/
                    <?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_SCHEDULED ?>">
                            <?php echo ' ' . \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount([
                                'filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_SCHEDULED, 'campaign_id' => $item->id]
                            ]) ?>
                        </a>
                    </li>
                </ul>
                <strong>
                    <h6 class="titulo-seccion"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Estados de entrega'); ?></h6>
                </strong>
                <form action="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/editcampaign') ?>/<?php echo $item->id ?>" class="custom-form mt-3" method="post">
                    <div class="input-group">
                        <input placeholder="Example@gmail.com" class="form-control" name="email" type="email" style="max-width: 300px;">
                        <button class="btn btn-success" type="submit">
                            <span class="material-icons">send</span>
                            <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Send information'); ?>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
</div>


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
            <h3>⏱ Métricas de lectura</h3>
            <div class="mini-botones-grid">
                <div class="mini-recuadro">
                    <span>Promedio de lectura</span>
                    <br>
                    <strong><?php echo $promedioLectura; ?></strong>
                </div>
                <div class="mini-recuadro">
                    <span>Lectura más rápida</span>
                    <br>
                    <strong><?php echo $lecturaRapida; ?></strong>
                </div>
                <div class="mini-recuadro">
                    <span>Lectura más lenta</span>
                    <br>
                    <strong><?php echo $lecturaLenta; ?></strong>
                </div>
                <div class="mini-recuadro">
                    <span>Día con mayor interacción</span>
                    <br>
                    <strong><?php echo $diaMayorInteraccion; ?></strong>
                </div>
                <div class="mini-recuadro">
                    <span>Día con menor interacción</span>
                    <br>
                    <strong><?php echo $diaMenorInteraccion; ?></strong>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="stats-right">
                <?php if (!empty($clicksPorBoton)) : ?>
                    <h4>
                        📊 Botones de la plantilla (ranking de clics)
                    </h4>
                    <div class="mini-botones">
                        <?php foreach ($clicksPorBoton as $boton => $cantidad) : ?>
                            <div class="mini-recuadro">
                                <span><?php echo htmlspecialchars($boton); ?></span>
                                <br>
                                <strong><?php echo $cantidad; ?></strong>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<a class="btn btn-primary" href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaign') ?>"><span class="material-icons">reply</span>Regresar al panel</a>

</div>