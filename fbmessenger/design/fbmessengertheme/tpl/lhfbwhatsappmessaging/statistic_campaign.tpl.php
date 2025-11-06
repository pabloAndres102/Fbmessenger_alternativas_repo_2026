<style>
    .recuadro {
        background: #000000ff;
        border-radius: 12px;
        padding: 0;
        margin-bottom: 0;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease-in-out;
    }

    .columna-lectura .mini-recuadro strong {
        font-size: 22px;
        /* tamaño más grande de la negrilla */
        font-weight: 800;
        /* más grueso */
        color: #1b5e20;
        /* verde oscuro elegante */
        display: block;
        margin-top: 5px;
    }

    .columna-lectura .mini-recuadro span {
        font-size: 14px;
        /* texto de etiqueta un poco más pequeño */
        color: #333;
        font-weight: 500;
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
        grid-template-columns: 2fr 1.2fr;
        /* le da más espacio a la gráfica */
        gap: 30px;
        margin-top: 20px;
        align-items: stretch;
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

    .grafico-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
        padding: 24px;
        text-align: center;
        transition: all 0.3s ease;
    }

    .grafico-card h6 {
        font-weight: 600;
        color: #222;
        margin-bottom: 12px;
        text-align: center;
    }

    .grafico-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 14px rgba(0, 0, 0, 0.12);
    }

    .grafico-card canvas {
        width: 120px !important;
        height: 120px !important;
    }

    .grafico-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        padding: 20px;
        text-align: center;
        height: 100%;
    }

    .grafico-card h6 {
        font-weight: 600;
        color: #222;
        margin-bottom: 10px;
    }

    .grafico-wrapper {
        background: #f9f9f9;
        border-radius: 16px;
        padding: 20px;
        position: relative;
        width: 280px;
        height: 280px;
        margin: 0 auto;
    }

    .grafico-wrapper canvas {
        width: 100% !important;
        height: 100% !important;
    }


    .grafico-card h6 {
        margin: 8px 0 5px 0;
        font-weight: bold;
        font-size: 13px;
        color: #444;
        text-align: center;
    }

    .stats-grafico-layout {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 15px;
    }

    @media (max-width: 768px) {
        .stats-grafico-layout {
            flex-direction: column;
            align-items: center;
        }
    }

    .info-stats-two-columns {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        margin-top: 20px;
        align-items: flex-start;
    }

    @media (max-width: 992px) {
        .info-stats-two-columns {
            grid-template-columns: 1fr;
        }
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
        <h4><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Campaign report'); ?>:</h4>
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

                <li>
                    <strong>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Template'); ?>
                    </strong>
                    &nbsp;-&nbsp;
                    <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsapp/metric_templates'); ?>?template_id=<?php echo urlencode($template_id); ?>"
                        target="_blank"
                        rel="noopener noreferrer"
                        style="color: #00bcd4; text-decoration: none;">
                        <?php echo htmlspecialchars((string)$item->template); ?>
                    </a>
                </li>

                <li><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Date send'); ?></strong> - <?php echo $item->starts_at ?></li>
                <li><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Phone sender'); ?></strong> -&nbsp;
                    <?php foreach ($phones as $phone) : ?>
                        <?php echo $phone['display_phone_number'] ?>
                    <?php endforeach; ?>
                </li>
                <li><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Department'); ?></strong> - <?php echo htmlspecialchars((string)$department) ?></li>
                <li><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Status'); ?></strong> -&nbsp;
                    <?php if ($item->status == LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaign::STATUS_PENDING) : ?>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Pending'); ?>
                    <?php elseif ($item->status == LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaign::STATUS_IN_PROGRESS) : ?>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'In progress'); ?>
                    <?php elseif ($item->status == LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaign::STATUS_FINISHED) : ?>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Finished'); ?>
                    <?php endif; ?>
                </li>
                <li><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Total recipients'); ?></strong> -&nbsp;
                    <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaignrecipient') ?>/(campaign)/<?php echo $item->id ?>">
                        <?php echo \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['campaign_id' => $item->id]]) ?>
                    </a>
                </li>
                <?php if (!empty($listasCampania)) : ?>
                    <li>
                        <strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Associated Lists'); ?></strong> -
                        <ul style="margin-top:5px; margin-left:15px;">
                            <?php foreach ($listasCampania as $lista): ?>
                                <li>
                                    <?php echo htmlspecialchars($lista['name']); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php else: ?>
                    <li><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Associated Lists'); ?></strong> - <em><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'No lists linked'); ?></em></li>
                <?php endif; ?>
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
                    <h6 class="titulo-seccion"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Share report'); ?></h6>
                </strong>
                <form action="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/editcampaign') ?>/<?php echo $item->id ?>" class="custom-form mt-3" method="post">
                    <div class="input-group">
                        <input placeholder="Ejemplo@gmail.com" class="form-control" name="email" type="email" style="max-width: 300px;">
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
                <p>
                    <strong>Mensajes enviados</strong>
                    <span class="material-icons text-info ms-1" 
                          data-bs-toggle="tooltip" 
                          data-bs-placement="top" 
                          title="Cantidad total de mensajes enviados, entregados o leídos.">
                        info
                    </span>
                </p>
                <h1><?php echo $mensajesEnviados; ?></h1>
            </div>

            <div class="recuadro">
                <p>
                    <strong>Tasa de efectividad (%)</strong>
                    <span class="material-icons text-info ms-1" 
                          data-bs-toggle="tooltip" 
                          data-bs-placement="top" 
                          title="Porcentaje de mensajes enviados exitosamente sobre el total de intentos.">
                        info
                    </span>
                </p>
                <h1><?php echo $tasaEnvio; ?>%</h1>
            </div>

            <div class="recuadro">
                <p>
                    <strong>Tasa de respuesta (%)</strong>
                    <span class="material-icons text-info ms-1" 
                          data-bs-toggle="tooltip" 
                          data-bs-placement="top" 
                          title="Porcentaje de mensajes que recibieron respuesta del usuario.">
                        info
                    </span>
                </p>
                <h1><?php echo $tasaRespuesta; ?>%</h1>
            </div>

            <div class="recuadro">
                <p>
                    <strong>Tasa de rebote (%)</strong>
                    <span class="material-icons text-info ms-1" 
                          data-bs-toggle="tooltip" 
                          data-bs-placement="top" 
                          title="Porcentaje de mensajes que fallaron, fueron rechazados o están pendientes.">
                        info
                    </span>
                </p>
                <h1><?php echo $tasaRebote; ?>%</h1>
            </div>

        </div>
    </div>
</div>



<div role="tabpanel" class="tab-pane" id="statistic">
    <div class="info-stats-two-columns">

        <!-- 📘 Columna izquierda: Métricas de lectura -->
        <div class="columna-lectura">
            <h3>⏱ Métricas de lectura</h3>
            <div class="mini-botones-grid">
                <div class="mini-recuadro">
                    <span>Promedio de lectura</span><br>
                    <strong><?php echo $promedioLectura; ?></strong>
                </div>
                <div class="mini-recuadro">
                    <span>Lectura más rápida</span><br>
                    <strong><?php echo $lecturaRapida; ?></strong>
                </div>
                <div class="mini-recuadro">
                    <span>Lectura más lenta</span><br>
                    <strong><?php echo $lecturaLenta; ?></strong>
                </div>
                <div class="mini-recuadro">
                    <span>Día con mayor interacción</span><br>
                    <strong><?php echo $diaMayorInteraccion; ?></strong>
                </div>
                <div class="mini-recuadro">
                    <span>Día con menor interacción</span><br>
                    <strong><?php echo $diaMenorInteraccion; ?></strong>
                </div>
            </div>
        </div>

        <!-- 📊 Columna derecha: Ranking + gráfico -->
        <div class="columna-ranking">
            <div class="stats-right">
                <?php if (!empty($clicksPorBoton)) : ?>
                    <h4>📊 Botones de la plantilla (ranking de clics)</h4>
                    <div class="mini-botones">
                        <?php foreach ($clicksPorBoton as $boton => $cantidad) : ?>
                            <div class="mini-recuadro">
                                <span><?php echo htmlspecialchars($boton); ?></span><br>
                                <strong><?php echo $cantidad; ?></strong>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- 🎯 Gráfico en tarjeta -->
                <div class="grafico-card">
                    <h6>📈 Distribución de mensajes (últimos 15 días)</h6>
                    <div class="grafico-wrapper">
                        <canvas id="chartEstados"></canvas>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<a class="btn btn-primary" href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaign') ?>"><span class="material-icons">reply</span>Regresar al panel</a>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

<script>
    const ctx = document.getElementById('chartEstados').getContext('2d');

    const dataRead = <?php echo (int)($readCount2 ?? 0); ?>;
    const dataDelivered = <?php echo (int)($deliveredCount2 ?? 0); ?>;
    const dataSent = <?php echo (int)($sentCount2 ?? 0); ?>;
    const total = dataRead + dataDelivered + dataSent || 1;

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Leídos', 'Entregados', 'Enviados'],
            datasets: [{
                data: [dataRead, dataDelivered, dataSent],
                backgroundColor: ['#2ECC71', '#F1C40F', '#E74C3C'],
                borderWidth: 2,
                borderColor: '#fff',
                hoverOffset: 10,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '60%', // menos hueco central = más espacio para texto
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#333',
                        font: {
                            size: 14,
                            weight: '500',
                            family: 'Poppins, sans-serif'
                        },
                        usePointStyle: true,
                        padding: 15
                    }
                },
                tooltip: {
                    backgroundColor: '#333',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    cornerRadius: 8,
                    padding: 10,
                    callbacks: {
                        label: function(context) {
                            const value = context.parsed || 0;
                            const percentage = ((value / total) * 100).toFixed(1);
                            return `${context.label}: ${value} (${percentage}%)`;
                        }
                    }
                },
                datalabels: {
                    color: '#fff',
                    textStrokeColor: '#000',
                    textStrokeWidth: 2,
                    shadowBlur: 6,
                    shadowColor: 'rgba(0,0,0,0.4)',
                    font: {
                        weight: 'bold',
                        size: 16,
                    },
                    formatter: (value) => {
                        const percentage = ((value / total) * 100).toFixed(1);
                        return percentage > 0 ? `${percentage}%` : '';
                    }
                }
            },
            animation: {
                animateRotate: true,
                animateScale: true,
                duration: 1500,
                easing: 'easeOutBounce'
            }
        },
        plugins: [ChartDataLabels]
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
})
</script>
