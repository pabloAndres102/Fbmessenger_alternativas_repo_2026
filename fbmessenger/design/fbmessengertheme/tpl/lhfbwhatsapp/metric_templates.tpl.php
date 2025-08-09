<style>
    .container2 {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-top: 20px;
        gap: 20px;
        /* Espacio entre los elementos */
    }

    .template-preview {
        width: 25%;
        box-sizing: border-box;
        border: 2px solid #ddd;
        /* Borde más grueso */
        border-radius: 8px;
        /* Radio del borde */
        padding: 20px;
        background-color: #fff;
        overflow: auto;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        /* Sombra más pronunciada */
        transition: box-shadow 0.3s ease, border-color 0.3s ease;
        /* Transición para efectos de hover */
    }

    .template-preview:hover {
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        /* Sombra más pronunciada al pasar el ratón */
        border-color: #3498db;
        /* Cambio de color de borde en hover */
    }



    .quality-indicator {
        width: 20px;
        height: 20px;
        display: inline-block;
        border-radius: 50%;
        margin-right: 8px;
        vertical-align: middle;
    }

    .quality-green {
        background-color: #4CAF50;
    }

    .quality-yellow {
        background-color: #FFEB3B;
    }

    .quality-red {
        background-color: #F44336;
    }

    .quality-unknown {
        background-color: #9E9E9E;
    }

    .quality-label {
        display: inline-block;
        vertical-align: middle;
        font-size: 16px;
        color: #333;
    }

    .tooltip-container {
        position: relative;
        display: inline-block;
        cursor: pointer;
    }

    .tooltip-container .tooltip-content {
        visibility: hidden;
        width: 300px;
        background-color: #f9f9f9;
        color: #333;
        text-align: left;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        position: absolute;
        z-index: 1;
        top: 125%;
        left: 50%;
        transform: translateX(-50%);
        box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.2);
        white-space: pre-line;
        overflow: auto;
    }

    .tooltip-container:hover .tooltip-content {
        visibility: visible;
    }

    .tooltip-item {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .tooltip-item:last-child {
        margin-bottom: 0;
    }

    .tooltip-item .circle {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin-right: 8px;
        display: block;
    }

    .tooltip-item.red .circle {
        background-color: red;
    }

    .tooltip-item.green .circle {
        background-color: green;
    }

    .tooltip-item.yellow .circle {
        background-color: yellow;
    }

    .tooltip-item.unknown .circle {
        background-color: gray;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: #fff;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: center;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #ddd;
    }

    canvas {
        width: 100% !important;
        height: auto !important;
        margin-top: 20px;
    }

    @media (max-width: 768px) {
        .container2 {
            flex-direction: column;
            align-items: center;
            gap: 20px;
            /* Espacio entre los elementos en vista móvil */
        }

        .template-preview,
        .info-box {
            width: 100%;
        }
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?php
if (isset($_GET['template_id'])) {
    $instance = LiveHelperChatExtension\fbmessenger\providers\FBMessengerWhatsAppLiveHelperChat::getInstance();
    $template = $instance->getTemplateById($_GET['template_id']);
}

?>
<body>
<h1><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger','Template metrics');?></h1>

    <div class="container2">
        <div class="info-box">

            <span class="quality-indicator quality-<?php echo strtolower($quality_score); ?>"></span>
            <span class="quality-label">
                <?php
                if ($quality_score == 'GREEN') {
                    echo 'Calidad Alta';
                } elseif ($quality_score == 'YELLOW') {
                    echo 'Calidad Media';
                } elseif ($quality_score == 'RED') {
                    echo 'Calidad Baja';
                } else {
                    echo 'Calidad Desconocida';
                }
                ?>
            </span>
            <span class="tooltip-container">
                <span class="tooltip-content">
                    <div class="tooltip-item red">
                        <span class="circle red"></span>
                        BAJA: La calidad es baja y suspendida o pausada debido a la alta cantidad de rebotes al momento de envíos o bloqueos por parte de los clientes.
                    </div>
                    <div class="tooltip-item green">
                        <span class="circle green"></span>
                        ALTA: Tu plantilla cumple con todos los requisitos de calidad.
                    </div>
                    <div class="tooltip-item yellow">
                        <span class="circle yellow"></span>
                        MEDIA: Debes tener cuidado, esta plantilla puede ser suspendida por abuso en rebotes o aumento de bloqueos o denuncias por parte de los clientes.
                    </div>
                    <div class="tooltip-item unknown">
                        <span class="circle unknown"></span>
                        DESCONOCIDA: No tienes el suficiente volumen para calificar esta plantilla.
                    </div>
                </span>
                &nbsp;&nbsp;<span class="material-icons">help</span>
            </span>
            <br><br>
            <h6><strong>Nombre de plantilla: </strong><?php echo htmlspecialchars($template['name']) ?></h6>
            <h6><strong>Categoria de plantilla: </strong><span style="color: black;" class="badge badge-secondary"><?php echo htmlspecialchars($template['category']) ?></span></h6>
            <h6><strong>Idioma de plantilla: </strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', $template['language']); ?></h6>
            <small><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Summary of the last 30 days'); ?></small><br><br>
            <h1 style="font-size: 24px; color: #3498db; margin-bottom: 10px;">
                <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/pendingchats', 'Datos consolidados') ?>
                <span class="material-icons">query_stats</span>
            </h1>
            <p style="font-size: 18px; margin-bottom: 10px;">
                <strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Sended') ?>:&nbsp;</strong> <?php print_r($info_sent) ?>
            </p>
            <p style="font-size: 18px; margin-bottom: 10px; display: inline-flex; align-items: center;">
                <strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Delivered') ?>:&nbsp;</strong> <?php print_r($info_delivered) ?>
                <span class="tooltip-container" title="Número de mensajes que la plataforma logró entregar de forma efectiva a los clientes. Es posible que algunos mensajes no se entreguen, como cuando el dispositivo de un cliente está fuera de servicio, pero quedan en cola hasta que el dispositivo esté encendido o en cobertura de señal.">
                    &nbsp;&nbsp;<span class="material-icons">help</span>
                </span>
            </p>
            <p style="font-size: 18px;">
                <strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Readed') ?>:&nbsp;</strong> <?php print_r($info_read) ?>
                <span class="tooltip-container" title="Número de mensajes que el negocio envió a los clientes y que se entregaron y leyeron. Es posible que algunas lecturas de mensajes no se incluyan, como cuando el cliente desactiva las confirmaciones de lectura.">
                    &nbsp;&nbsp;<span class="material-icons">help</span>
                </span>
            </p>

        </div>
            <div class="template-preview rounded bg-light p-2" title="<?php echo htmlspecialchars(json_encode($template, JSON_PRETTY_PRINT)) ?>">
                <?php foreach ($template['components'] as $component) : ?>
                    <?php if ($component['type'] == 'HEADER' && $component['format'] == 'IMAGE' && isset($component['example']['header_url'][0])) : ?>
                        <img src="<?php echo htmlspecialchars($component['example']['header_url'][0]) ?>" />
                    <?php endif; ?>
                    <?php if ($component['type'] == 'HEADER' && $component['format'] == 'DOCUMENT' && isset($component['example']['header_url'][0])) : ?>
                        <div>
                            <span class="badge badge-secondary">FILE: <?php echo htmlspecialchars($component['example']['header_url'][0]) ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if ($component['type'] == 'HEADER' && $component['format'] == 'VIDEO' && isset($component['example']['header_url'][0])) : ?>
                        <div>
                            <span class="badge badge-secondary">VIDEO: <?php echo htmlspecialchars($component['example']['header_url'][0]) ?></span>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php foreach ($template['components'] as $component) : ?>
                    <?php if ($component['type'] == 'BODY') :
                        $matchesReplace = [];
                        preg_match_all('/\{\{[0-9]\}\}/is', $component['text'], $matchesReplace);
                        if (isset($matchesReplace[0])) {
                            $fieldsCount = count($matchesReplace[0]);
                        }
                    ?><p><?php echo htmlspecialchars($component['text']) ?></p><?php endif; ?>
                    <?php if ($component['type'] == 'HEADER') : ?>
                        <?php if ($component['format'] == 'DOCUMENT') : $fieldCountHeaderDocument = 1; ?>
                            <!-- <h5 class="text-secondary">DOCUMENT</h5> -->
                        <?php elseif ($component['format'] == 'VIDEO') : $fieldCountHeaderVideo = 1; ?>
                            <!-- <h5 class="text-secondary">VIDEO</h5> -->
                            <?php if (isset($component['example']['header_handle'][0])) : ?>
                                <video width="100">
                                    <source src="<?php echo htmlspecialchars($component['example']['header_handle'][0]) ?>" type="video/mp4">
                                </video>
                            <?php endif; ?>
                        <?php elseif ($component['format'] == 'IMAGE') : $fieldCountHeaderImage = 1; ?>
                            <!-- <h5 class="text-secondary">IMAGE</h5> -->
                            <?php if (isset($component['example']['header_handle'][0])) : ?>
                                <img src="<?php echo htmlspecialchars($component['example']['header_handle'][0]) ?>" width="100px" />
                            <?php endif; ?>
                        <?php else : ?>
                            <?php
                            $matchesReplace = [];
                            preg_match_all('/\{\{[0-9]\}\}/is', $component['text'], $matchesReplace);
                            if (isset($matchesReplace[0])) {
                                $fieldsCountHeader = count($matchesReplace[0]);
                            }
                            ?>
                            <h5 class="text-secondary"><?php echo htmlspecialchars($component['text']) ?></h5>
                        <?php endif; ?>

                    <?php endif; ?>
                    <?php if ($component['type'] == 'FOOTER') : ?><p class="text-secondary"><?php echo htmlspecialchars($component['text']) ?></p><?php endif; ?>
                    <?php if ($component['type'] == 'BUTTONS') : ?>
                        <?php foreach ($component['buttons'] as $button) : ?>
                            <div class="pb-2"><button class="btn btn-sm btn-secondary"><?php echo htmlspecialchars($button['text']) ?> | <?php echo htmlspecialchars($button['type']) ?></button></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php
                foreach ($template['components'] as $component) :
                    if ($component['type'] === 'CAROUSEL' && isset($component['cards']) && is_array($component['cards'])) : ?>
                        <h5><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Carousel'); ?></h5>
                        <?php foreach ($component['cards'] as $card) : ?>
                            <?php foreach ($card['components'] as $cardComponent) : ?>
                                <?php if ($cardComponent['type'] == 'BODY') : ?>
                                    <p><?php echo htmlspecialchars($cardComponent['text']) ?></p>
                                <?php endif; ?>
                                <?php if ($cardComponent['type'] == 'BUTTONS') : ?>
                                    <?php foreach ($cardComponent['buttons'] as $button) : ?>
                                        <div class="pb-2"><button class="btn btn-sm btn-secondary"><?php echo htmlspecialchars($button['text']) ?> | <?php echo htmlspecialchars($button['type']) ?></button></div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <?php if ($cardComponent['format'] == 'VIDEO') : ?>
                                    <video width="100">
                                        <source src="<?php echo htmlspecialchars($cardComponent['example']['header_handle'][0]) ?>" type="video/mp4">
                                    </video>
                                <?php endif; ?>
                                <?php if ($cardComponent['format'] == 'IMAGE') : ?>
                                    <img src="<?php print_r($cardComponent['example']['header_handle'][0]) ?>" width="100px">
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
        </div>

    </div>
    <br>
    <table>
        <tr>
            <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Start') ?></th>
            <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'End') ?></th>
            <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Sended') ?></th>
            <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Delivered') ?></th>
            <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Readed') ?></th>
            <th>Clicks</th>
        </tr>
        <?php
        $end = time(); // Obtiene la fecha y hora actual en formato Unix.

        // Restar 90 días (90 * 24 * 60 * 60 segundos) a la fecha actual.
        $start = $end - (89 * 24 * 60 * 60);

        if (isset($metrics) && !empty($metrics)) :
            $data_points = $metrics['data'][0]['data_points'];
            foreach (array_slice($data_points, $pages->low, $pages->items_per_page) as $data_point) : ?>
                <?php if ($data_point['sent'] > 0) : ?>
                    <tr>
                        <td><?php print_r(date('d/m/Y', $data_point['start'])); ?></td>
                        <td><?php print_r(date('d/m/Y', $data_point['end'])); ?></td>
                        <td><?php print_r($data_point['sent']); ?></td>
                        <td><?php print_r($data_point['delivered']); ?></td>
                        <td><?php print_r($data_point['read']); ?></td>
                        <td>
                            <?php if (isset($data_point['clicked'])) : ?>
                                <ul>
                                    <?php foreach ($data_point['clicked'] as $clickedItem) : ?>
                                        <li>
                                            <strong> <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Button name') ?>: </strong> <?php print_r($clickedItem['button_content']); ?><br>
                                            <strong> Clicks: </strong> <?php print_r($clickedItem['count']); ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else : ?>
                                N/A
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else : ?>
            <?php print_r($metrics) ?>
        <?php endif; ?>
    </table>
    <br>
    <center>
        <h4>Estado de envios de plantilla</h4>
        <canvas id="lineChart" width="400" height="200"></canvas>
        <center>
            <h4>Interaccion de botones de plantilla</h4>
        </center>
        <canvas id="barChart" width="400" height="200"></canvas>


        <script>
            // Datos en formato JSON desde PHP
            var labels = <?php echo $labelsJson; ?>;
            var sentData = <?php echo $sentDataJson; ?>;
            var deliveredData = <?php echo $deliveredDataJson; ?>;
            var readData = <?php echo $readDataJson; ?>;
            var clickLabels = <?php echo $clickLabelsJson; ?>;
            var clickedData = <?php echo $clickedDataJson; ?>;

            // Configuración del gráfico de líneas
            var ctx = document.getElementById('lineChart').getContext('2d');
            var lineChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Enviado',
                            data: sentData,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            fill: false
                        },
                        {
                            label: 'Entregado',
                            data: deliveredData,
                            borderColor: 'rgba(153, 102, 255, 1)',
                            backgroundColor: 'rgba(153, 102, 255, 0.2)',
                            fill: false
                        },
                        {
                            label: 'Leído',
                            data: readData,
                            borderColor: 'rgba(255, 159, 64, 1)',
                            backgroundColor: 'rgba(255, 159, 64, 0.2)',
                            fill: false
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Count'
                            },
                            beginAtZero: true,
                            ticks: {
                                callback: function(value, index, values) {
                                    // Muestra solo valores enteros
                                    return Number.isInteger(value) ? value : '';
                                }
                            }
                        }
                    }
                }
            });
            var ctxBar = document.getElementById('barChart').getContext('2d');
            var barChart = new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: clickLabels,
                    datasets: [{
                        label: 'Clics',
                        data: clickedData,
                        backgroundColor: 'rgba(54, 162, 235, 0.8)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Fecha'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Cantidad'
                            },
                            beginAtZero: true,
                            ticks: {
                                callback: function(value, index, values) {
                                    // Muestra solo valores enteros
                                    return Number.isInteger(value) ? value : '';
                                }
                            }
                        }
                    }
                }
            });
        </script>






        <!-- <td><?php print_r($data_point[0]['data_points'][0]['delivered']); ?></td> -->

</body>

</html>
<!-- <script>
    // Obtén el botón y el div por su ID
    var showInfoButton = document.getElementById('showInfoButton');
    var infoDiv = document.getElementById('infoDiv');

    // Agrega un evento de clic al botón
    showInfoButton.addEventListener('click', function() {
        // Comprueba si el div está visible
        if (infoDiv.style.display === 'none') {
            // Si está oculto, muéstralo
            infoDiv.style.display = 'block';
        } else {
            // Si está visible, ocúltalo
            infoDiv.style.display = 'none';
        }
    });
</script> -->