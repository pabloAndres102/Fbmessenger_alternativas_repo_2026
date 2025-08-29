<style>
    .chart-section {
        margin-bottom: 40px;
        padding: 20px;
        background: #fff;
        border-radius: 12px;
        /* sombra más notoria */
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .chart-section:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.35);
    }

    .chart-title {
        font-size: 1.2rem;
        margin-bottom: 15px;
        text-align: center;
        font-weight: 600;
        color: #333;
    }

    .chart-warning {
        color: red;
        font-style: italic;
        text-align: center;
    }

    .recuadro {
        position: relative;
        background-color: #ffffff;
        border: 1px solid #e3e6f0;
        border-radius: 10px;
        padding: 20px 25px;
        margin-bottom: 20px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        text-align: left;
        width: 100%;
    }

    .recuadro:hover {
        background-color: #f1f3f5;
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        border-color: #d1d5db;
        cursor: pointer;
    }

    /* Icono en esquina superior derecha */
    .recuadro .icon-top-right {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 28px;
        /* Más grande */
        transition: transform 0.3s;
    }

    /* Hover suave para iconos */
    .recuadro:hover .icon-top-right {
        transform: scale(1.2);
    }

    /* Iconos con colores según tipo */
    .icon-send {
        color: #0d6efd;
    }

    .icon-slow {
        color: #dc3545;
    }

    .icon-fast {
        color: #ffc107;
    }

    /* Azul para enviados */
    .icon-trending {
        color: #20c997;
    }

    .icon-template {
        color: #0d6efd;
    }

    /* Verde para tasas/estadísticas positivas */
    .icon-inbox {
        color: #ffc107;
    }

    /* Amarillo para bandeja/entradas */
    .icon-error {
        color: #dc3545;
    }

    /* Rojo para fallidos */
    .icon-check {
        color: #198754;
    }

    select.form-control {
        padding: 8px 12px;
        border: 1px solid #ced4da;
        border-radius: 6px;
        font-size: 14px;
        outline: none;
        width: auto;
        display: inline-block;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    select.form-control:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
    }

    .chart-title {
        font-size: 26px;
        color: #2c3e50;
        margin-bottom: 15px;
        text-align: center;
        font-weight: 600;
    }

    /* Estilos para los inputs de fecha */
    input[type="datetime-local"] {
        padding: 8px 12px;
        border: 1px solid #ced4da;
        border-radius: 6px;
        font-size: 14px;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    input[type="datetime-local"]:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
    }

    /* Estilos para los botones */
    button.btn {
        padding: 10px 18px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        background-color: #007bff;
        color: #fff;
        font-size: 14px;
        font-weight: 500;
        transition: background-color 0.3s, transform 0.2s;
    }

    button.btn:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
    }

    /* Iconos dentro de botones */
    span.material-icons {
        vertical-align: middle;
        margin-right: 6px;
        font-size: 18px;
    }

    /* Estilos para los recuadros */
    .recuadro,
    .recuadro-button {
        background-color: #ffffff;
        border: 1px solid #e3e6f0;
        border-radius: 10px;
        padding: 20px 25px;
        margin-bottom: 20px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        text-align: left;
        width: 100%;
    }

    .recuadro:hover,
    .recuadro-button:hover {
        background-color: #f1f3f5;
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        border-color: #d1d5db;
        cursor: pointer;
    }

    .recuadro p,
    .recuadro h1,
    .recuadro-button p,
    .recuadro-button h1 {
        margin: 0;
    }

    /* Estilo de los números dentro de recuadro */
    .recuadro h1,
    .recuadro-button h1 {
        font-size: 34px;
        color: #1d4ed8;
        font-weight: 600;
    }

    /* Botones dentro de recuadro (sin fondo predeterminado) */
    .recuadro-button {
        background: none;
        border: none;
        padding: 0;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<?php
$businessAccount = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppAccount::getList();
?>
<div class="container">
    <h1><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Statistics'); ?></h1>
    <br>
    <form method="POST" action="<?php echo erLhcoreClassDesign::baseurl('fbmessenger/index') ?>" id="dateForm">
        <input type="datetime-local" name="start" id="startDate" value="<?php echo (isset($startTimestamp) ? date('Y-m-d\TH:i', $startTimestamp) : date('Y-m-d\TH:i')); ?>">&nbsp;&nbsp;
        <input type="datetime-local" name="end" id="endDate" value="<?php echo (isset($endTimestamp) ? date('Y-m-d\TH:i', $endTimestamp) : date('Y-m-d\TH:i')); ?>">&nbsp;&nbsp;

        <input type="tel" name="phone" id="phoneNumber" placeholder="Numero telefonico" pattern="[0-9]{10,15}" title="Please enter a valid phone number (10-15 digits)." style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; box-sizing: border-box; font-size: 14px; outline: none;">&nbsp;&nbsp;

        <select name="businessAccount" class="form-control form-control-sm">
            <option value=""><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Cuenta comercial'); ?></option>
            <?php foreach ($businessAccount as $account): ?>
                <option value="<?php echo $account->id; ?>">
                    <?php echo htmlspecialchars($account->name); ?>
                </option>
            <?php endforeach; ?>
        </select>&nbsp;&nbsp;

        <button class="btn btn-primary" type="submit">
            <span class="material-icons">search</span><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('system/buttons', 'Search'); ?>
        </button>
    </form>



    <br>
    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
            <form method="GET" action="<?php echo erLhcoreClassDesign::baseurl('fbmessenger/indicators') ?>" class="indicatorForm">
                <input type="hidden" name="status_statistic" value="1,2,3,6,7">
                <input type="hidden" name="start" class="startDate">
                <input type="hidden" name="end" class="endDate">
                <button type="submit" class="recuadro-button">
                    <div class="recuadro">
                        <p><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Sent conversations'); ?></strong></p>
                        <?php if (isset($totalSent)) : ?>
                            <h1><?php echo $totalSent; ?></h1>
                            <span class="material-icons">visibility</span>
                            <span class="material-icons icon-top-right icon-send">send</span>
                        <?php endif; ?>
                    </div>
                </button>
            </form>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
            <form method="GET" action="<?php echo erLhcoreClassDesign::baseurl('fbmessenger/indicators') ?>" class="indicatorForm">
                <input type="hidden" name="status_statistic" value="3">
                <input type="hidden" name="start" class="startDate">
                <input type="hidden" name="end" class="endDate">
                <button type="submit" class="recuadro-button">
                    <div class="recuadro">
                        <p><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Tasa de envio en %'); ?></strong></p>
                        <?php if (isset($totalRead)) : ?>
                            <h1><?php echo $totalRead; ?></h1>
                            <span class="material-icons">visibility</span>
                            <span class="material-icons icon-top-right icon-trending">trending_up</span>
                        <?php endif; ?>
                    </div>
                </button>
            </form>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
            <div class="recuadro"> <!-- Recuadro 3 -->
                <p><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Tasa de respuesta en %'); ?></strong></p>
                <?php if (isset($engagement)) : ?>
                    <h1><?php print_r($engagement . '%'); ?></h1>
                <?php endif; ?>
                <span class="material-icons icon-top-right icon-response">question_answer</span>
            </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
            <div class="recuadro"> <!-- Recuadro 2 -->
                <p><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Incoming conversations'); ?></strong></p>
                <?php if (isset($msg_services)) : ?>
                    <h1><?php echo $msg_services; ?></h1><small>(api)</small>

                <?php endif; ?>
            </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
            <form method="GET" action="<?php echo erLhcoreClassDesign::baseurl('fbmessenger/indicators') ?>" class="indicatorForm">
                <input type="hidden" name="conversation">
                <input type="hidden" name="start" class="startDate">
                <input type="hidden" name="end" class="endDate">
                <button type="submit" class="recuadro-button">
                    <div class="recuadro">
                        <p><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Generated conversations'); ?></strong></p>
                        <?php if (isset($chatid)) : ?>
                            <h1><?php echo $chatid; ?></h1>
                            <span class="material-icons">visibility</span>
                        <?php endif; ?>
                        <span class="material-icons icon-top-right icon-generated">chat_bubble</span>
                    </div>
                </button>
            </form>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
            <div class="recuadro"> <!-- Recuadro 4 -->
                <p><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Promedio de lectura'); ?></strong></p>
                <?php if (isset($averageTime)) : ?>
                    <h1><?php echo $averageTime; ?></h1>
                <?php endif; ?>
                <span class="material-icons icon-top-right icon-average">bar_chart</span>
            </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
            <div class="recuadro"> <!-- Recuadro 4 -->
                <p><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Lectura más rápida'); ?></strong></p>
                <?php if (isset($fastestTime)) : ?>
                    <h1><?php echo $fastestTime; ?></h1>
                <?php else : ?>
                    <h1>Sin datos</h1>
                <?php endif; ?>
                <span class="material-icons icon-top-right icon-fast">flash_on</span>
            </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
            <div class="recuadro"> <!-- Recuadro 4 -->
                <p><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Lectura más lenta'); ?></strong></p>
                <?php if (isset($slowestTime)) : ?>
                    <h1><?php echo $slowestTime; ?></h1>
                <?php else : ?>
                    <h1>Sin datos</h1>
                <?php endif; ?>
                <span class="material-icons icon-top-right icon-slow">schedule</span>
            </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
            <form method="GET" action="<?php echo erLhcoreClassDesign::baseurl('fbmessenger/indicators') ?>" class="indicatorForm">
                <input type="hidden" name="status_statistic" value="2">
                <input type="hidden" name="start" class="startDate">
                <input type="hidden" name="end" class="endDate">
                <button type="submit" class="recuadro-button">
                    <div class="recuadro">
                        <p><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Estado entregado'); ?></strong></p>
                        <?php if (isset($deliveredCount)) : ?>
                            <h1><?php echo $deliveredCount; ?></h1>
                            <span class="material-icons">visibility</span>
                            <span class="material-icons icon-top-right icon-check">check_circle</span>
                        <?php endif; ?>
                    </div>
                </button>
            </form>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
            <form method="GET" action="<?php echo erLhcoreClassDesign::baseurl('fbmessenger/indicators') ?>" class="indicatorForm">
                <input type="hidden" name="status_statistic" value="6">
                <input type="hidden" name="start" class="startDate">
                <input type="hidden" name="end" class="endDate">
                <button type="submit" class="recuadro-button">
                    <div class="recuadro">
                        <p><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Estado fallido'); ?></strong></p>
                        <?php if (isset($failedCount)) : ?>
                            <h1><?php echo $failedCount; ?></h1>
                            <span class="material-icons">visibility</span>
                            <span class="material-icons icon-top-right icon-error">error</span>
                        <?php endif; ?>
                    </div>
                </button>
            </form>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
            <form method="GET" action="<?php echo erLhcoreClassDesign::baseurl('fbmessenger/indicators') ?>">
                <input type="hidden" name="status_statistic" value="7">
                <input type="hidden" name="start" class="startDate">
                <input type="hidden" name="end" class="endDate">
                <button type="submit" class="recuadro-button">
                    <div class="recuadro">
                        <p><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Estado rechazado'); ?></strong></p>
                        <?php if (isset($rejectedCount)) : ?>
                            <h1><?php echo $rejectedCount; ?></h1>
                            <span class="material-icons">visibility</span>
                            <span class="material-icons icon-top-right icon-error">cancel</span>
                        <?php endif; ?>
                    </div>
                </button>
            </form>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
            <div class="recuadro"> <!-- Recuadro 4 -->
                <p><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Plantilla más enviada'); ?></strong></p>
                <?php if (isset($mostRepeatedTemplate)) : ?>
                    <h1 style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?php echo $mostRepeatedTemplate; ?></h1>
                    <p>(<?php echo $maxFrequency; ?>)</p>
                <?php else : ?>
                    <h1>Sin datos</h1>
                <?php endif; ?>
                <span class="material-icons icon-top-right icon-template">content_copy</span>
            </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
            <div class="recuadro"> <!-- Recuadro 4 -->
                <p><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Día que se envió más plantillas'); ?></strong></p>
                <?php if (isset($dayWithMostMessages)) : ?>
                    <h1><?php echo $dayWithMostMessages; ?></h1>
                    <p>(<?php echo $maxMessages; ?>)</p>
                <?php else : ?>
                    <h1>Sin datos</h1>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
            <div class="recuadro"> <!-- Recuadro 4 -->
                <p><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'día mayor tasa de interaccion'); ?></strong></p>
                <?php if (isset($dayWithMaxEngagement)) : ?>
                    <h1><?php echo $dayWithMaxEngagement; ?></h1>
                <?php else : ?>
                    <h1>Sin datos</h1>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
            <div class="recuadro"> <!-- Recuadro 4 -->
                <p><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'día menor tasa de interaccion'); ?></strong></p>
                <?php if (isset($dayWithMinEngagement)) : ?>
                    <h1><?php echo $dayWithMinEngagement; ?></h1>
                <?php endif; ?>
            </div>
        </div>
    </div>


    <div class="container-graphics" style="max-width:1200px; margin:auto; padding:20px;">

        <!-- Plantillas enviadas -->
        <section class="chart-section">
            <h3 class="chart-title">
                <span class="material-icons" style="vertical-align:middle; color:#1976d2;">send</span>
                Plantillas enviadas
            </h3>
            <p class="chart-warning">
                <span class="material-icons">warning</span> Importante: Esta información puede variar según la privacidad definida por el usuario.
            </p>
            <canvas id="myChart" height="120"></canvas>
        </section>

        <!-- chats sin respuesta -->

        <section class="chart-section">
            <h3 class="chart-title">
                <span class="material-icons" style="vertical-align:middle; color:#e53935;">chat_off</span>
                Chats sin respuesta
            </h3>
            <p class="chart-warning">
                <span class="material-icons">warning</span> Importante: Los chats sin respuesta corresponden al rango de fechas seleccionado.
            </p>
            <canvas id="unansweredChart" height="120"></canvas>
        </section>

        <!-- cantidad promedio y picos de chat por hora -->

        <section class="chart-section">
            <h3 class="chart-title">
                <span class="material-icons" style="vertical-align:middle; color:#1976d2;">schedule</span>
                Promedio y pico de chats por hora
            </h3>
            <p class="chart-warning">
                <span class="material-icons">info</span> El promedio se calcula en base al rango de fechas seleccionado.
            </p>
            <canvas id="chatsHoraChart" height="120"></canvas>
        </section>



        <!-- Número de mensajes -->
        <section class="chart-section">
            <h3 class="chart-title">
                <span class="material-icons" style="vertical-align:middle; color:#f57c00;">forum</span>
                Número de mensajes por hora
            </h3>
            <canvas id="workLoadChart" height="150"></canvas>
        </section>

        <!-- Chats por hora -->

        <!-- Estado de las Plantillas -->
        <section class="chart-section">
            <h3 class="chart-title">
                <span class="material-icons" style="vertical-align:middle; color:#7b1fa2;">pie_chart</span>
                Estado de las Plantillas
            </h3>
            <center><canvas id="pieChart" width="400" height="400"></canvas></center>
        </section>

        <!-- Tiempo de espera -->
        <section class="chart-section">
            <h3 class="chart-title">
                <span class="material-icons" style="vertical-align:middle; color:#e53935;">hourglass_bottom</span>
                ⏳ Promedio de tiempo de espera por asesor
            </h3>
            <canvas id="graficoEspera" style="width:100%; height:400px;"></canvas>
        </section>

        <!-- Envíos por agente -->
        <section class="chart-section">
            <h3 class="chart-title">
                <span class="material-icons" style="vertical-align:middle; color:#6d4c41;">groups</span>
                Envíos por agente
            </h3>
            <center><canvas id="pieChartAgents" width="400" height="400"></canvas></center>
        </section>

        <!-- Plantillas leídas -->
        <section class="chart-section">
            <h3 class="chart-title">
                <span class="material-icons" style="vertical-align:middle; color:#2e7d32;">drafts</span>
                Plantillas leídas
            </h3>
            <p class="chart-warning">
                <span class="material-icons">warning</span> Importante: Esta información puede variar según la privacidad definida por el usuario.
            </p>
            <canvas id="myChartRead" height="120"></canvas>
        </section>

        <!-- Conversaciones generadas -->
        <section class="chart-section">
            <h3 class="chart-title">
                <span class="material-icons" style="vertical-align:middle; color:#00897b;">chat_bubble</span>
                Conversaciones generadas por Plantillas
            </h3>
            <canvas id="myChartGenerated" height="120"></canvas>
        </section>

        <!-- Engagement -->
        <section class="chart-section">
            <h3 class="chart-title">
                <span class="material-icons" style="vertical-align:middle; color:#c2185b;">trending_up</span>
                Engagement diario
            </h3>
            <canvas id="myChartEngagement" height="120"></canvas>
        </section>
    </div>

</div>
<?php
$labels = [];
$currentDate = $startTimestamp;

while ($currentDate <= $endTimestamp) {
    $labels[] = date('Y-m-d', $currentDate);
    $currentDate = strtotime('+1 day', $currentDate); // Avanzar al siguiente día
}
?>
<script>
    // Obtener contexto
    var ctx = document.getElementById('myChart').getContext('2d');

    // Datos
    var data = {
        labels: <?php echo json_encode($labels); ?>,
        datasets: [{
                label: 'Enviadas',
                backgroundColor: 'rgba(33, 150, 243, 0.7)',
                borderColor: 'rgba(33, 150, 243, 1)',
                borderWidth: 2,
                borderRadius: 6,
                data: <?php echo json_encode($sentPerDay); ?>,
                type: 'bar',
                order: 1
            },
            {
                label: 'Leídas',
                borderColor: 'rgba(255, 152, 0, 1)',
                backgroundColor: 'rgba(255, 152, 0, 0.15)',
                borderWidth: 2,
                tension: 0.4, // curva suave
                fill: true,
                pointBackgroundColor: 'rgba(255, 152, 0, 1)',
                data: <?php echo json_encode($readPerDay); ?>,
                type: 'line',
                order: 2
            },
            {
                label: 'Entregadas',
                borderColor: 'rgba(76, 175, 80, 1)',
                backgroundColor: 'rgba(76, 175, 80, 0.15)',
                borderWidth: 2,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: 'rgba(76, 175, 80, 1)',
                data: <?php echo json_encode($deliveredPerDay); ?>,
                type: 'line',
                order: 3
            }
        ]
    };

    // Opciones
    var options = {
        responsive: true,
        plugins: {
    legend: {
        position: 'top',
        align: 'end',
        labels: {
            usePointStyle: true,
            boxWidth: 12,
            padding: 15,
            font: {
                size: 13,
                weight: '600'
            }
        }
    },
    datalabels: {
        anchor: 'center',   // 👈 cambia de 'end' a 'center'
        align: 'center',    // 👈 centra dentro de la barra
        color: '#fff',      // 👈 blanco para que contraste con la barra azul
        font: {
            weight: 'bold',
            size: 12
        },
        formatter: function(value) {
            return value > 0 ? value : '';
        }
    }
},
        scales: {
            x: {
                grid: {
                    display: false
                },
                ticks: {
                    font: {
                        size: 12
                    }
                }
            },
            y: {
                beginAtZero: true,
                ticks: {
                    font: {
                        size: 12
                    }
                },
                grid: {
                    color: 'rgba(0,0,0,0.05)'
                }
            }
        }
    };

    // Crear gráfico
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: options,
        plugins: [ChartDataLabels]
    });

    // Agregar dinámicamente messagesPerDay
    var messagesPerDay = <?php echo json_encode($messagesPerDay); ?>;
    Object.keys(messagesPerDay).forEach(function(date) {
        if (!data.labels.includes(date)) {
            data.labels.push(date);
        }
        data.datasets[0].data.push(messagesPerDay[date]); // Enviadas
    });

    myChart.update();
</script>

<script>
    // Datos pasados desde PHP
    const labelsUnanswered = <?php echo json_encode($labelsUnanswered); ?>;
    const totalesUnanswered = <?php echo json_encode($totalesUnanswered); ?>;

    // Renderizar gráfico
    const ctxUnanswered = document.getElementById('unansweredChart').getContext('2d');
    new Chart(ctxUnanswered, {
        type: 'bar',
        data: {
            labels: labelsUnanswered,
            datasets: [{
                label: 'Chats sin respuesta',
                data: totalesUnanswered,
                backgroundColor: 'rgba(229, 57, 53, 0.7)', // rojo suave
                borderColor: 'rgba(229, 57, 53, 1)',       // rojo fuerte
                borderWidth: 1,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        usePointStyle: true,
                        padding: 15,
                        font: {
                            size: 13,
                            weight: '600'
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: (context) => ` ${context.parsed.y} chats`
                    }
                },
                datalabels: {
                    anchor: 'center',   // posición dentro de la barra
                    align: 'center',    // centrado vertical
                    color: '#fff',      // blanco para contraste
                    font: {
                        weight: 'bold',
                        size: 12
                    },
                    formatter: function(value) {
                        return value > 0 ? value : '';
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    },
                    title: {
                        display: true,
                        text: 'Número de chats'
                    },
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Periodo (mes/día)'
                    },
                    grid: {
                        display: false
                    }
                }
            }
        },
        plugins: [ChartDataLabels] // 👈 importante: activar plugin
    });
</script>

<script>
    // Variables enviadas desde PHP
    const labelsHora   = <?php echo json_encode($labels); ?>;          // ["00:00", "01:00", ...]
    const totalesHora  = <?php echo json_encode($totales); ?>;         // total por hora
    const promediosHora= <?php echo json_encode($promedios); ?>;       // promedio por hora
    const maximosHora  = <?php echo json_encode($maximos); ?>;         // pico por hora

    const ctxHora = document.getElementById('chatsHoraChart').getContext('2d');
    new Chart(ctxHora, {
        type: 'bar',
        data: {
            labels: labelsHora,
            datasets: [
                {
                    type: 'bar',
                    label: 'Total de chats',
                    data: totalesHora,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    borderRadius: 6
                },
                {
                    type: 'line',
                    label: 'Promedio de chats',
                    data: promediosHora,
                    borderColor: 'rgba(255, 206, 86, 1)',
                    backgroundColor: 'rgba(255, 206, 86, 0.2)',
                    fill: false,
                    tension: 0.3,
                    borderWidth: 2,
                    pointRadius: 4
                },
                {
                    type: 'line',
                    label: 'Pico máximo de chats',
                    data: maximosHora,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    fill: false,
                    tension: 0.3,
                    borderWidth: 2,
                    pointRadius: 4
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                tooltip: {
                    mode: 'index',
                    intersect: false
                },
                legend: {
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Número de chats'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Hora del día'
                    }
                }
            }
        }
    });
</script>


<script>
    var labels = [
        "00h", "01h", "02h", "03h", "04h", "05h", "06h",
        "07h", "08h", "09h", "10h", "11h", "12h",
        "13h", "14h", "15h", "16h", "17h", "18h",
        "19h", "20h", "21h", "22h", "23h"
    ];

    var data = {
        labels: labels,
        datasets: [{
            label: 'Chats por hora',
            backgroundColor: 'rgba(33, 150, 243, 0.8)',
            borderColor: 'rgba(33, 150, 243, 1)',
            borderWidth: 2,
            borderRadius: 6,
            data: <?php echo json_encode($workLoadStats['total']); ?>
        }]
    };

    var ctx = document.getElementById('workLoadChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false // ocultamos leyenda porque solo hay un dataset
                },
                datalabels: {
                    anchor: 'center', // centra el label dentro de la barra
                    align: 'center', // lo alinea en el centro vertical
                    color: 'white', // color del texto dentro de la barra (elige uno que contraste)
                    font: {
                        weight: 'bold',
                        size: 16
                    },
                    formatter: function(value) {
                        return value > 0 ? value : '';
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 12
                        }
                    },
                    categoryPercentage: 0.6,
                    barPercentage: 0.9,
                    title: {
                        display: true,
                        text: 'Hora del día', // Título del eje X
                        font: {
                            size: 14,
                            weight: 'bold'
                        },
                        color: '#333'
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        font: {
                            size: 12
                        }
                    },
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    },
                    title: {
                        display: true,
                        text: 'Cantidad de chats', // Título del eje Y
                        font: {
                            size: 14,
                            weight: 'bold'
                        },
                        color: '#333'
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var ctx = document.getElementById('graficoEspera').getContext('2d');

        function formatTiempo(segundos) {
            if (segundos < 60) return segundos + " seg";
            if (segundos < 3600) {
                let min = Math.floor(segundos / 60);
                let resto = segundos % 60;
                return min + " min" + (resto > 0 ? " " + resto + " seg" : "");
            }
            let horas = Math.floor(segundos / 3600);
            let restoMin = Math.floor((segundos % 3600) / 60);
            return horas + " h" + (restoMin > 0 ? " " + restoMin + " min" : "");
        }

        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($asesores); ?>,
                datasets: [{
                    label: 'Promedio de espera',
                    data: <?php echo json_encode($promediosEspera); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.8)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },

                    tooltip: {
                        callbacks: {
                            label: function(ctx) {
                                return formatTiempo(ctx.raw);
                            }
                        }
                    },
                    datalabels: {
                        anchor: 'center', // dentro de la barra
                        align: 'center', // centrado vertical y horizontal
                        color: '#fff', // blanco para que contraste
                        font: {
                            weight: 'bold',
                            size: 16
                        },
                        formatter: function(value) {
                            return formatTiempo(value);
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return formatTiempo(value);
                            }
                        },
                        title: {
                            display: true,
                            text: 'Tiempo de espera'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Asesores'
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    });
</script>

<script>
    // Obtener context de Canvas
    var ctx = document.getElementById('pieChartAgents').getContext('2d');

    // Datos para el gráfico
    var data = {
        labels: <?php echo json_encode($agentNames); ?>,
        datasets: [{
            data: <?php echo json_encode($messageCounts); ?>,
            backgroundColor: [
                'rgba(128, 0, 128, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 99, 132, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(75, 192, 192, 0.6)',
                'rgba(153, 102, 255, 0.6)'
            ],
            borderColor: '#fff',
            borderWidth: 2
        }]
    };

    // Opciones del gráfico
    var options = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'right',
                labels: {
                    usePointStyle: true,
                    padding: 15,
                    font: {
                        size: 16,
                        weight: '600'
                    },
                    generateLabels: function(chart) {
                        const data = chart.data;
                        if (data.labels.length && data.datasets.length) {
                            return data.labels.map((label, i) => {
                                const value = data.datasets[0].data[i];
                                return {
                                    text: `${label}: ${value}`,
                                    fillStyle: data.datasets[0].backgroundColor[i],
                                    strokeStyle: data.datasets[0].backgroundColor[i],
                                    lineWidth: 1,
                                    hidden: isNaN(value) || chart.getDatasetMeta(0).data[i].hidden,
                                    index: i
                                };
                            });
                        }
                        return [];
                    }
                }
            },
            datalabels: {
                color: '#fff',
                font: {
                    weight: 'bold',
                    size: 16
                },
                formatter: function(value, context) {
                    let dataset = context.chart.data.datasets[0];
                    let total = dataset.data.reduce((a, b) => a + b, 0);
                    let percentage = ((value / total) * 100).toFixed(1) + "%";
                    return value + " (" + percentage + ")";
                }
            }
        }
    };

    // Crear el gráfico de pastel
    var pieChart = new Chart(ctx, {
        type: 'pie',
        data: data,
        options: options,
        plugins: [ChartDataLabels]
    });
</script>



<script>
    // Obtener context de Canvas
    var ctx = document.getElementById('pieChart').getContext('2d');

    // Datos para el gráfico
    var data = {
        labels: ['Leídos', 'Enviado', 'Fallido', 'Entregado', 'Rechazado', 'Pendiente'],
        datasets: [{
            data: [
                <?php echo $totalRead ?>,
                <?php echo $sentCount ?>,
                <?php echo $failedCount ?>,
                <?php echo $deliveredCount ?>,
                <?php echo $rejectedCount ?>,
                <?php echo $pendingCount ?>
            ],
            backgroundColor: [
                'rgba(255, 99, 132, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(75, 192, 192, 0.6)',
                'rgba(153, 102, 255, 0.6)',
                'rgba(46, 204, 113, 0.6)'
            ],
            borderColor: "#fff",
            borderWidth: 2
        }]
    };

    // Opciones del gráfico
    var options = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'right',
                labels: {
                    usePointStyle: true,
                    padding: 15,
                    font: {
                        size: 16,
                        weight: '600'
                    },
                    generateLabels: function(chart) {
                        const data = chart.data;
                        if (data.labels.length && data.datasets.length) {
                            return data.labels.map((label, i) => {
                                const value = data.datasets[0].data[i];
                                if (value === 0) return null; // ignorar 0
                                return {
                                    text: `${label}: ${value}`,
                                    fillStyle: data.datasets[0].backgroundColor[i],
                                    strokeStyle: data.datasets[0].backgroundColor[i],
                                    lineWidth: 1,
                                    hidden: false,
                                    index: i
                                };
                            }).filter(item => item !== null);
                        }
                        return [];
                    }
                }
            },
            datalabels: {
                color: '#fff',
                font: {
                    weight: 'bold',
                    size: 16
                },
                formatter: function(value, context) {
                    if (value === 0) return ''; // ignorar 0
                    let dataset = context.chart.data.datasets[0];
                    let total = dataset.data.reduce((a, b) => a + b, 0);
                    let percentage = ((value / total) * 100).toFixed(1) + "%";
                    return value + " (" + percentage + ")";
                }
            }
        }
    };

    // Crear el gráfico de pastel
    var pieChart = new Chart(ctx, {
        type: 'pie',
        data: data,
        options: options,
        plugins: [ChartDataLabels]
    });
</script>

<script>
    // Obtener el contexto del lienzo
    var ctx = document.getElementById('myChartRead').getContext('2d');

    // Datos
    var data = {
        labels: <?php echo json_encode($labels); ?>,
        datasets: [{
            label: 'Leídas',
            backgroundColor: 'rgba(255, 206, 86, 0.8)',
            borderColor: 'rgba(255, 206, 86, 1)',
            borderWidth: 2,
            borderRadius: 6,
            data: <?php echo json_encode($readPerDay); ?>
        }]
    };

    // Configuración del gráfico
    var options = {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
                align: 'end',
                labels: {
                    usePointStyle: true,
                    font: {
                        size: 16,
                        weight: '600'
                    },
                    padding: 15
                }
            },
            datalabels: {
                anchor: 'center',
                align: 'center',
                color: 'black',
                font: {
                    weight: 'bold',
                    size: 16
                },
                formatter: function(value) {
                    return value > 0 ? value : '';
                }
            }
        },
        scales: {
            x: {
                grid: {
                    display: false
                },
                ticks: {
                    font: {
                        size: 16
                    }
                },
                categoryPercentage: 0.6,
                barPercentage: 0.9
            },
            y: {
                beginAtZero: true,
                ticks: {
                    font: {
                        size: 16
                    }
                },
                grid: {
                    color: 'rgba(0,0,0,0.05)'
                }
            }
        }
    };

    // Crear el gráfico
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: options,
        plugins: [ChartDataLabels]
    });

    // Agregar dinámicamente mensajes por día
    var messagesPerDay = <?php echo json_encode($messagesPerDay); ?>;
    Object.keys(messagesPerDay).forEach(function(date) {
        if (!data.labels.includes(date)) data.labels.push(date);
        data.datasets[0].data.push(messagesPerDay[date]);
    });

    myChart.update();
</script>

<script>
    // Obtener el contexto del lienzo
    var ctx = document.getElementById('myChartGenerated').getContext('2d');

    // Datos
    var data = {
        labels: <?php echo json_encode($labels); ?>,
        datasets: [{
            label: 'Conversaciones generadas',
            backgroundColor: 'rgba(75, 192, 192, 0.8)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 2,
            borderRadius: 6,
            data: <?php echo json_encode($generatedConversationPerDay); ?>
        }]
    };

    // Configuración del gráfico
    var options = {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
                align: 'end',
                labels: {
                    usePointStyle: true,
                    font: {
                        size: 16,
                        weight: '600'
                    },
                    padding: 15
                }
            },
            datalabels: {
                anchor: 'center',
                align: 'center',
                color: 'white',
                font: {
                    weight: 'bold',
                    size: 16
                },
                formatter: function(value) {
                    return value > 0 ? value : '';
                }
            }
        },
        scales: {
            x: {
                grid: {
                    display: false
                },
                categoryPercentage: 0.6,
                barPercentage: 0.9
            },
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0,0,0,0.05)'
                },
                ticks: {
                    font: {
                        size: 16
                    }
                }
            }
        }
    };

    // Crear el gráfico
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: options,
        plugins: [ChartDataLabels]
    });

    // Agregar dinámicamente mensajes por día
    var messagesPerDay = <?php echo json_encode($messagesPerDay); ?>;
    Object.keys(messagesPerDay).forEach(function(date) {
        if (!data.labels.includes(date)) data.labels.push(date);
        data.datasets[0].data.push(messagesPerDay[date]);
    });

    myChart.update();
</script>

<script>
    // Obtener el contexto del lienzo
    var ctx = document.getElementById('myChartEngagement').getContext('2d');

    // Datos
    var data = {
        labels: <?php echo json_encode($labels); ?>,
        datasets: [{
            label: 'Engagement',
            backgroundColor: 'rgba(54, 162, 235, 0.8)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 2,
            borderRadius: 6,
            data: <?php echo json_encode($engagementValues); ?>
        }]
    };

    // Configuración del gráfico
    var options = {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
                align: 'end',
                labels: {
                    usePointStyle: true,
                    font: {
                        size: 16,
                        weight: '600'
                    },
                    padding: 15
                }
            },
            datalabels: {
                anchor: 'center',
                align: 'center',
                color: 'white',
                font: {
                    weight: 'bold',
                    size: 16
                },
                formatter: function(value) {
                    return value > 0 ? value + '%' : '';
                }
            }
        },
        scales: {
            x: {
                grid: {
                    display: false
                },
                categoryPercentage: 0.6,
                barPercentage: 0.9
            },
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0,0,0,0.05)'
                },
                ticks: {
                    font: {
                        size: 12
                    }
                }
            }
        }
    };

    // Crear el gráfico
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: options,
        plugins: [ChartDataLabels]
    });

    // Agregar dinámicamente mensajes por día
    var messagesPerDay = <?php echo json_encode($messagesPerDay); ?>;
    Object.keys(messagesPerDay).forEach(function(date) {
        if (!data.labels.includes(date)) data.labels.push(date);
        data.datasets[0].data.push(messagesPerDay[date]);
    });

    myChart.update();
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dateForm = document.getElementById('dateForm');
        const startDateField = document.getElementById('startDate');
        const endDateField = document.getElementById('endDate');
        const indicatorForms = document.querySelectorAll('.indicatorForm');

        function updateIndicatorForms() {
            const startDate = startDateField.value;
            const endDate = endDateField.value;

            indicatorForms.forEach(function(form) {
                form.querySelector('.startDate').value = startDate;
                form.querySelector('.endDate').value = endDate;
            });
        }

        indicatorForms.forEach(function(form) {
            form.addEventListener('submit', function(event) {
                updateIndicatorForms();
            });
        });
    });
</script>