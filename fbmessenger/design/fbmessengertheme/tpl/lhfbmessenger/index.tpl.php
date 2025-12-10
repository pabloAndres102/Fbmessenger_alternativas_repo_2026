<!--
  UNIFICACIÓN FINAL: Vista rediseñada para LiveHelperChat (Whatsapp statistics)
-->

<!-- Dependencias -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<style>
.chart-download-btn {
  position: absolute;
  top: 10px;
  right: 10px;
  background: #2b6cb0;
  color: white;
  border: none;
  border-radius: 6px;
  padding: 6px 10px;
  font-size: 12px;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 4px;
  z-index: 10;
}
.chart-download-btn .material-icons {
  font-size: 14px;
}
.chart-section {
  position: relative;
}
.stats-cards {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}

:root{
  --card-bg: #deeaf4ff;
  --border: #e6e9ef;
  --muted: #6b7280;
  --primary: #2b6cb0;
  --accent: #f6ad55;
  --success: #16a34a;
  --danger: #e53e3e;
  --radius: 12px;
  --transition: 200ms ease;
}

.chart-section.full-width {
  grid-column: 1 / -1;
}

.canvas-wrap {
  width: 100% !important;
}

canvas {
  width: 100% !important;
}


/* Layout */
.lh-wrapper {width: 100%;max-width: 100%;margin: 0; padding: 18px; box-sizing: border-box;}
.lh-row { display: flex; flex-wrap: wrap; width: 100%; gap: 16px; align-items: stretch;}
.lh-col {flex: 1 1 calc(20% - 16px);max-width: calc(20% - 16px);}
@media (max-width: 1200px) {.lh-col {flex: 1 1 calc(25% - 16px);max-width: calc(25% - 16px); }}
@media (max-width: 992px) {.lh-col { flex: 1 1 calc(33.333% - 16px);  max-width: calc(33.333% - 16px);}}
@media (max-width: 576px) {.lh-col {  flex: 1 1 100%;  max-width: 100%;}}
.lh-col { padding: 8px; box-sizing: border-box; }
.lh-col-12 { flex: 0 0 100%; max-width:100%; }
@media(min-width:576px){ .lh-col-md-4 { flex: 0 0 33.3333%; max-width:33.3333%; } }
@media(min-width:992px){ .lh-col-lg-3 { flex: 0 0 20%; max-width:20%; } }

h1.page-title { font-size:24px; margin:4px 0 12px 0; font-weight:700; }

/* Form */
.stats-form { display:flex; flex-wrap:wrap; gap:8px; align-items:center; margin-bottom:16px; }
.stats-form input[type="datetime-local"], .stats-form input[type="tel"], .stats-form select { padding:10px 12px; border-radius:8px; border:1px solid var(--border); background: #fff; font-size:14px; transition: box-shadow var(--transition), border-color var(--transition); }
.stats-form input:focus, .stats-form select:focus { outline:none; box-shadow:0 4px 14px rgba(43,108,176,0.12); border-color: rgba(43,108,176,0.8); }
.btn-submit { padding:10px 16px; border-radius:8px; background:var(--primary); color:#fff; border:none; cursor:pointer; font-weight:600; display:inline-flex; align-items:center; gap:8px; }
.btn-submit .material-icons { font-size:18px; }

/* Cards */
.stat-card { background:var(--card-bg); border:1px solid var(--border); border-radius:var(--radius); padding:16px; box-shadow:0 2px 10px rgba(12,14,22,0.04); transition: transform var(--transition), box-shadow var(--transition); position:relative; overflow:hidden; width: 100%; }
.stat-card:hover { transform: translateY(-4px); box-shadow: 0 10px 30px rgba(12,14,22,0.07); }
.stat-title { font-size:13px; color:var(--muted); font-weight:700; margin-bottom:6px; text-transform:capitalize; }
.stat-value { font-size:28px; font-weight:700; color:var(--primary); }
.stat-sub { font-size:12px; color:var(--muted); margin-top:6px; display:block; }

.icon-top-right { position:absolute; right:12px; top:10px; font-size:26px; opacity:0.95; transition: transform var(--transition); }
.stat-card:hover .icon-top-right { transform:scale(1.12); }

/* Chart sections */
.container-graphics {margin-top:18px;display:grid;gap:18px;grid-template-columns: 1fr !important;}
.chart-section { background:var(--card-bg); border:1px solid var(--border); padding:16px; border-radius:12px; box-shadow:0 4px 18px rgba(12,14,22,0.03); }
.chart-title { font-size:16px; font-weight:700; margin-bottom:10px; display:flex; align-items:center; gap:8px; color: #0f1724; }
.chart-warning { font-size:13px; color:var(--danger); margin:6px 0 12px; display:flex; gap:8px; align-items:center; }

/* Canvas responsive wrapper */
.canvas-wrap { width:100%; height:450px; }
.canvas-wrap.small { height:350px; }
.canvas-wrap.tall { height:550px; }

.text-muted { color:var(--muted); font-size:13px; }
.center { text-align:center; }
.ellipsis { white-space:nowrap; overflow:hidden; text-overflow:ellipsis; display:block; }

.chart-title .material-icons { font-size:20px; color:var(--primary); }
</style>


<div class="lh-wrapper">

  <h1 class="page-title"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Whatsapp statistics'); ?></h1>

  <!-- Form -->
  <form id="dateForm" class="stats-form" method="POST" action="<?php echo erLhcoreClassDesign::baseurl('fbmessenger/index') ?>">
    <input type="datetime-local" name="start" id="startDate" value="<?php echo (isset($startTimestamp) ? date('Y-m-d\TH:i', $startTimestamp) : date('Y-m-d\TH:i')); ?>">
    <input type="datetime-local" name="end" id="endDate" value="<?php echo (isset($endTimestamp) ? date('Y-m-d\TH:i', $endTimestamp) : date('Y-m-d\TH:i')); ?>">
    <input type="tel" name="phone" id="phoneNumber" placeholder="Número telefónico" pattern="[0-9]{10,15}" title="Please enter a valid phone number (10-15 digits).">
    <select name="businessAccount" class="">
      <option value=""><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Cuenta comercial'); ?></option>
      <?php foreach ($businessAccount as $account): ?>
        <option value="<?php echo $account->id; ?>"><?php echo htmlspecialchars($account->name); ?></option>
      <?php endforeach; ?>
    </select>

    <button class="btn-submit" type="submit">
      <span class="material-icons">search</span>
      <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('system/buttons', 'Search'); ?>
    </button>
  </form>

  <!-- Small stats tiles -->
  <div class="lh-row">
    <div class="lh-col lh-col-12 lh-col-md-4 lh-col-lg-3">
      <form method="GET" action="<?php echo erLhcoreClassDesign::baseurl('fbmessenger/indicators') ?>" class="indicatorForm">
        <input type="hidden" name="status_statistic" value="1,2,3,6,7">
        <input type="hidden" name="start" class="startDate">
        <input type="hidden" name="end" class="endDate">
        <button type="submit" class="stat-card" style="width:100%; text-align:left; border:none;">
          <div class="stat-title"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Sent conversations'); ?></div>
          <div class="stat-value"><?php echo isset($totalSent) ? $totalSent : '—'; ?></div>
          <span class="material-icons icon-top-right" title="Enviadas">send</span>
        </button>
      </form>
    </div>

    <div class="lh-col lh-col-12 lh-col-md-4 lh-col-lg-3">
      <form method="GET" action="<?php echo erLhcoreClassDesign::baseurl('fbmessenger/indicators') ?>" class="indicatorForm">
        <input type="hidden" name="status_statistic" value="3">
        <input type="hidden" name="start" class="startDate">
        <input type="hidden" name="end" class="endDate">
        <button type="submit" class="stat-card" style="width:100%; text-align:left; border:none;">
          <div class="stat-title"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Tasa de envio en %'); ?></div>
          <div class="stat-value"><?php echo isset($tasaEnvio) ? $tasaEnvio . '%' : '—'; ?></div>
          <span class="material-icons icon-top-right" title="Tasa">trending_up</span>
        </button>
      </form>
    </div>

    <div class="lh-col lh-col-12 lh-col-md-4 lh-col-lg-3">
      <div class="stat-card">
        <div class="stat-title"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Tasa de respuesta en %'); ?></div>
        <div class="stat-value"><?php echo isset($engagement) ? $engagement . '%' : '—'; ?></div>
        <span class="material-icons icon-top-right" title="Engagement">question_answer</span>
      </div>
    </div>

    <div class="lh-col lh-col-12 lh-col-md-4 lh-col-lg-3">
      <div class="stat-card">
        <div class="stat-title"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Incoming conversations'); ?></div>
        <div class="stat-value"><?php echo isset($msg_services) ? $msg_services : '—'; ?></div>
        <span class="material-icons icon-top-right" title="Incoming">inbox</span>
      </div>
    </div>

    <!-- more cards (generated, avg read, fastest, slowest, delivered, failed, rejected, most repeated, day most sent, day max/min engagement) -->
    <div class="lh-col lh-col-12 lh-col-md-4 lh-col-lg-3">
      <form method="GET" action="<?php echo erLhcoreClassDesign::baseurl('fbmessenger/indicators') ?>" class="indicatorForm">
        <input type="hidden" name="conversation">
        <input type="hidden" name="start" class="startDate">
        <input type="hidden" name="end" class="endDate">
        <button type="submit" class="stat-card" style="width:100%; text-align:left; border:none;">
          <div class="stat-title"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Generated conversations'); ?></div>
          <div class="stat-value"><?php echo isset($chatid) ? $chatid : '—'; ?></div>
          <span class="material-icons icon-top-right" title="Generadas">chat_bubble</span>
        </button>
      </form>
    </div>

    <div class="lh-col lh-col-12 lh-col-md-4 lh-col-lg-3">
      <div class="stat-card">
        <div class="stat-title"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Promedio de lectura'); ?></div>
        <div class="stat-value"><?php echo isset($averageTime) ? $averageTime : '—'; ?></div>
        <span class="material-icons icon-top-right" title="Promedio lectura">bar_chart</span>
      </div>
    </div>

    <div class="lh-col lh-col-12 lh-col-md-4 lh-col-lg-3">
      <div class="stat-card">
        <div class="stat-title"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Lectura más rápida'); ?></div>
        <div class="stat-value"><?php echo isset($fastestTime) ? $fastestTime : 'Sin datos'; ?></div>
        <span class="material-icons icon-top-right" title="Rápida">flash_on</span>
      </div>
    </div>

    <div class="lh-col lh-col-12 lh-col-md-4 lh-col-lg-3">
      <div class="stat-card">
        <div class="stat-title"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Lectura más lenta'); ?></div>
        <div class="stat-value"><?php echo isset($slowestTime) ? $slowestTime : 'Sin datos'; ?></div>
        <span class="material-icons icon-top-right" title="Lenta">schedule</span>
      </div>
    </div>

    <div class="lh-col lh-col-12 lh-col-md-4 lh-col-lg-3">
      <form method="GET" action="<?php echo erLhcoreClassDesign::baseurl('fbmessenger/indicators') ?>" class="indicatorForm">
        <input type="hidden" name="status_statistic" value="2">
        <input type="hidden" name="start" class="startDate">
        <input type="hidden" name="end" class="endDate">
        <button type="submit" class="stat-card" style="width:100%; text-align:left; border:none;">
          <div class="stat-title"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Estado entregado'); ?></div>
          <div class="stat-value"><?php echo isset($deliveredCount) ? $deliveredCount : '—'; ?></div>
          <span class="material-icons icon-top-right" title="Entregado">check_circle</span>
        </button>
      </form>
    </div>

    <div class="lh-col lh-col-12 lh-col-md-4 lh-col-lg-3">
      <form method="GET" action="<?php echo erLhcoreClassDesign::baseurl('fbmessenger/indicators') ?>" class="indicatorForm">
        <input type="hidden" name="status_statistic" value="6">
        <input type="hidden" name="start" class="startDate">
        <input type="hidden" name="end" class="endDate">
        <button type="submit" class="stat-card" style="width:100%; text-align:left; border:none;">
          <div class="stat-title"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Estado fallido'); ?></div>
          <div class="stat-value"><?php echo isset($failedCount) ? $failedCount : '—'; ?></div>
          <span class="material-icons icon-top-right" title="Fallido">error</span>
        </button>
      </form>
    </div>

    <div class="lh-col lh-col-12 lh-col-md-4 lh-col-lg-3">
      <form method="GET" action="<?php echo erLhcoreClassDesign::baseurl('fbmessenger/indicators') ?>">
        <input type="hidden" name="status_statistic" value="7">
        <input type="hidden" name="start" class="startDate">
        <input type="hidden" name="end" class="endDate">
        <button type="submit" class="stat-card" style="width:100%; text-align:left; border:none;">
          <div class="stat-title"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Estado rechazado'); ?></div>
          <div class="stat-value"><?php echo isset($rejectedCount) ? $rejectedCount : '—'; ?></div>
          <span class="material-icons icon-top-right" title="Rechazado">cancel</span>
        </button>
      </form>
    </div>

    <div class="lh-col lh-col-12 lh-col-md-4 lh-col-lg-3">
      <div class="stat-card">
        <div class="stat-title"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Plantilla más enviada'); ?></div>
        <div class="stat-value ellipsis"><?php echo isset($mostRepeatedTemplate) ? $mostRepeatedTemplate : 'Sin datos'; ?></div>
        <span class="stat-sub"><?php echo isset($maxFrequency) ? '(' . $maxFrequency . ')' : ''; ?></span>
        <span class="material-icons icon-top-right" title="Plantilla">content_copy</span>
      </div>
    </div>

    <div class="lh-col lh-col-12 lh-col-md-4 lh-col-lg-3">
      <div class="stat-card">
        <div class="stat-title"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Día que se envió más plantillas'); ?></div>
        <div class="stat-value"><?php echo isset($dayWithMostMessages) ? $dayWithMostMessages : 'Sin datos'; ?></div>
        <span class="stat-sub"><?php echo isset($maxMessages) ? '(' . $maxMessages . ')' : ''; ?></span>
      </div>
    </div>

    <div class="lh-col lh-col-12 lh-col-md-4 lh-col-lg-3">
      <div class="stat-card">
        <div class="stat-title"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'día mayor tasa de interaccion'); ?></div>
        <div class="stat-value"><?php echo isset($dayWithMaxEngagement) ? $dayWithMaxEngagement : 'Sin datos'; ?></div>
      </div>
    </div>

    <div class="lh-col lh-col-12 lh-col-md-4 lh-col-lg-3">
      <div class="stat-card">
        <div class="stat-title"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'día menor tasa de interaccion'); ?></div>
        <div class="stat-value"><?php echo isset($dayWithMinEngagement) ? $dayWithMinEngagement : 'Sin datos'; ?></div>
      </div>
    </div>

  </div> <!-- end stats row -->

  <!-- Charts area -->
  <div class="container-graphics">
    <!-- Plantillas enviadas -->
    <section class="chart-section full-width">
  <div class="chart-title"><span class="material-icons">send</span> Plantillas enviadas</div>
  <div class="chart-warning"><span class="material-icons">warning</span> Importante: Esta información puede variar según la privacidad definida por el usuario.</div>
  <div class="canvas-wrap small">
    <canvas id="sentChart"></canvas>
  </div>
</section>

    <!-- Chats sin respuesta -->
    <section class="chart-section full-width">
  <div class="chart-title"><span class="material-icons">chat_off</span> Chats sin respuesta</div>
  <div class="chart-warning"><span class="material-icons">warning</span> Importante: Los chats sin respuesta corresponden al rango de fechas seleccionado.</div>
  <div class="canvas-wrap small">
    <canvas id="unansweredChart"></canvas>
  </div>
</section>

    <!-- Promedio y pico de chats por hora -->
    <section class="chart-section">
      <div class="chart-title"><span class="material-icons">schedule</span> Promedio y pico de chats por hora</div>
      <div class="canvas-wrap small"><canvas id="chatsHoraChart"></canvas></div>
    </section>

    <!-- Número de mensajes por hora -->
    <section class="chart-section">
      <div class="chart-title"><span class="material-icons">forum</span> Número de mensajes por hora</div>
      <div class="canvas-wrap small"><canvas id="workLoadChart"></canvas></div>
    </section>

    <!-- Estado de las Plantillas -->
    <section class="chart-section">
      <div class="chart-title"><span class="material-icons">pie_chart</span> Estado de las Plantillas</div>
      <div class="canvas-wrap"><canvas id="pieStatusChart"></canvas></div>
    </section>

    <!-- Promedio de tiempo de espera por asesor -->
    <section class="chart-section">
      <div class="chart-title"><span class="material-icons">hourglass_bottom</span> ⏳ Promedio de tiempo de espera por asesor</div>
      <div class="canvas-wrap tall"><canvas id="graficoEspera"></canvas></div>
    </section>

    <!-- Envíos por agente -->
    <section class="chart-section">
      <div class="chart-title"><span class="material-icons">groups</span> Envíos por agente</div>
      <div class="canvas-wrap"><canvas id="pieChartAgents"></canvas></div>
    </section>

    <!-- Plantillas leídas -->
    <section class="chart-section">
      <div class="chart-title"><span class="material-icons">drafts</span> Plantillas leídas</div>
      <div class="chart-warning"><span class="material-icons">warning</span> Importante: Esta información puede variar según la privacidad definida por el usuario.</div>
      <div class="canvas-wrap small"><canvas id="myChartRead"></canvas></div>
    </section>

    <!-- Conversaciones generadas por Plantillas -->
    <section class="chart-section">
      <div class="chart-title"><span class="material-icons">chat_bubble</span> Conversaciones generadas por Plantillas</div>
      <div class="canvas-wrap small"><canvas id="myChartGenerated"></canvas></div>
    </section>

    <!-- Engagement diario -->
    <section class="chart-section">
      <div class="chart-title"><span class="material-icons">trending_up</span> Engagement diario</div>
      <div class="canvas-wrap small"><canvas id="myChartEngagement"></canvas></div>
    </section>
  </div> <!-- end charts -->

</div> <!-- lh-wrapper -->

<!-- ---------------------------
     SCRIPTS UNIFICADOS PARA CHARTS
---------------------------- -->
<script>
  (function(){
    // Utils
    const safeParse = (v, fallback=[]) => { try { return (typeof v !== 'undefined') ? JSON.parse(JSON.stringify(v)) : fallback; } catch(e) { return fallback; } };
    const labels = safeParse(<?php echo json_encode(isset($labels) ? $labels : []); ?>);
    const messagesPerDay = safeParse(<?php echo json_encode(isset($messagesPerDay) ? $messagesPerDay : (object)[]); ?>);

    // Colors
    const palette = {
      blue: 'rgba(33,150,243,0.85)',
      blueSoft: 'rgba(33,150,243,0.15)',
      orange: 'rgba(255,152,0,0.9)',
      green: 'rgba(76,175,80,0.85)',
      red: 'rgba(229,57,53,0.85)',
      purple: 'rgba(123,31,162,0.85)',
      teal: 'rgba(75,192,192,0.85)'
    };

    // Datalabels common
    const datalabelsCenter = {
      anchor:'center', align:'center', color:'#fff', font:{weight:'700', size:12},
      formatter: (value) => (value>0?value:'')
    };

    // Small helper to merge messagesPerDay into given dataset (if keys are date strings)
    function mergeMessagesIntoDataset(baseLabels, datasetData, messagesObj){
      // messagesObj may be { '2025-11-01': 5, ... } -> push values in same order as baseLabels
      try{
        const result = Array.isArray(datasetData) ? datasetData.slice(0) : [];
        baseLabels.forEach((lbl, idx) => {
          // if datasetData already has value at idx, keep it; else try messagesObj[lbl] or 0
          if (typeof result[idx] === 'undefined' || result[idx] === null) {
            result[idx] = (messagesObj && typeof messagesObj[lbl] !== 'undefined') ? messagesObj[lbl] : 0;
          }
        });
        return result;
      } catch(e){
        return datasetData;
      }
    }

    // Chart common options factory
    function baseOptions(titleText){
      return {
        responsive:true,
        plugins:{
          legend:{ position:'top', labels:{ usePointStyle:true, boxWidth:12, padding:12, font:{size:12, weight:'600'} } },
          datalabels: datalabelsCenter
        },
        scales: {
          x: { grid:{ display:false }, ticks:{ font:{ size:12 } } },
          y: { beginAtZero:true, ticks:{ font:{ size:12 } }, grid:{ color:'rgba(0,0,0,0.05)' } }
        }
      };
    }

    // -------- SENT CHART (sentChart) -----------
    (function(){
      const ctx = document.getElementById('sentChart')?.getContext('2d');
      if(!ctx) return;
      const sentPerDay = safeParse(<?php echo json_encode(isset($sentPerDay) ? $sentPerDay : []); ?>);
      const readPerDay = safeParse(<?php echo json_encode(isset($readPerDay) ? $readPerDay : []); ?>);
      const deliveredPerDay = safeParse(<?php echo json_encode(isset($deliveredPerDay) ? $deliveredPerDay : []); ?>);

      // ensure arrays align with labels
      const sentData = mergeMessagesIntoDataset(labels, sentPerDay, messagesPerDay);
      const readData = mergeMessagesIntoDataset(labels, readPerDay, messagesPerDay);
      const deliveredData = mergeMessagesIntoDataset(labels, deliveredPerDay, messagesPerDay);

      const data = {
        labels: labels,
        datasets: [
          { label:'Enviadas', type:'bar', data: sentData, backgroundColor: palette.blue, borderColor: palette.blue, borderWidth:2, borderRadius:6, order:1 },
          { label:'Leídas', type:'line', data: readData, borderColor: palette.orange, backgroundColor: 'rgba(255,152,0,0.12)', tension:0.35, fill:true, pointBackgroundColor:palette.orange, order:2 },
          { label:'Entregadas', type:'line', data: deliveredData, borderColor: palette.green, backgroundColor: 'rgba(76,175,80,0.12)', tension:0.35, fill:true, pointBackgroundColor:palette.green, order:3 }
        ]
      };

      const options = baseOptions('Plantillas enviadas');
      options.plugins.datalabels = { anchor:'end', align:'end', color:'#fff', font:{weight:'700', size:11}, formatter: v => v>0?v:'' };
      options.scales.x.ticks.maxRotation = 0;

      new Chart(ctx, { type:'bar', data, options, plugins:[ChartDataLabels] });
    })();

    // -------- UNANSWERED CHART -----------
    (function(){
      const ctx = document.getElementById('unansweredChart')?.getContext('2d');
      if(!ctx) return;
      const labelsUn = safeParse(<?php echo json_encode(isset($labelsUnanswered) ? $labelsUnanswered : []); ?>);
      const totalsUn = safeParse(<?php echo json_encode(isset($totalesUnanswered) ? $totalesUnanswered : []); ?>);

      new Chart(ctx, {
        type:'bar',
        data:{ labels: labelsUn, datasets:[ { label:'Chats sin respuesta', data: totalsUn, backgroundColor: 'rgba(229,57,53,0.85)', borderColor:'rgba(229,57,53,1)', borderWidth:1, borderRadius:6 } ] },
        options: {
    responsive: true,
    maintainAspectRatio: false,
    layout: {
        padding: 0
    },
    plugins: {
        legend: {
            display: true,
            labels: {
                usePointStyle: true,
                padding: 10,
                font: {
                    size: 12,
                    weight: '600'
                }
            }
        },
        tooltip: {
            callbacks: {
                label: (c) => ` ${c.parsed.y} chats`
            }
        },
        datalabels: {
            anchor: 'center',
            align: 'center',
            color: '#fff',
            font: {
                weight: '700',
                size: 11
            },
            formatter: v => v > 0 ? v : ''
        }
    },
    scales: {
        y: {
            beginAtZero: true,
            title: {
                display: true,
                text: 'Número de chats'
            },
            grid: {
                color: 'rgba(0,0,0,0.05)'
            }
        },
        x: {
            offset: false,
            grid: {
                display: false
            }
        }
    }
},

        plugins:[ChartDataLabels]
      });
    })();

    // -------- CHATS HORA (chatsHoraChart) -----------
    (function(){
      const ctx = document.getElementById('chatsHoraChart')?.getContext('2d');
      if(!ctx) return;
      const labelsHora   = safeParse(<?php echo json_encode(isset($labels) ? $labels : []); ?>);
      const totalesHora  = safeParse(<?php echo json_encode(isset($totales) ? $totales : []); ?>);
      const promediosHora= safeParse(<?php echo json_encode(isset($promedios) ? $promedios : []); ?>);
      const maximosHora  = safeParse(<?php echo json_encode(isset($maximos) ? $maximos : []); ?>);

      new Chart(ctx, {
        type:'bar',
        data:{
          labels: labelsHora,
          datasets:[
            { type:'bar', label:'Total de chats', data: totalesHora, backgroundColor:'rgba(54,162,235,0.5)', borderColor:'rgba(54,162,235,1)', borderWidth:1, borderRadius:6 },
            { type:'line', label:'Promedio de chats', data: promediosHora, borderColor:'rgba(255,206,86,1)', backgroundColor:'rgba(255,206,86,0.2)', fill:false, tension:0.3, borderWidth:2, pointRadius:3 },
            { type:'line', label:'Pico máximo de chats', data: maximosHora, borderColor:'rgba(255,99,132,1)', backgroundColor:'rgba(255,99,132,0.2)', fill:false, tension:0.3, borderWidth:2, pointRadius:3 }
          ]
        },
        options: {
    responsive: true,
    maintainAspectRatio: false,
    layout: {
        padding: 0
    },
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
            offset: false,
            title: {
                display: true,
                text: 'Hora del día'
            }
        }
    }
},

      });
    })();

    // -------- WORKLOAD (workLoadChart) -----------
    (function(){
      const ctx = document.getElementById('workLoadChart')?.getContext('2d');
      if(!ctx) return;
      const wlLabels = ['00h','01h','02h','03h','04h','05h','06h','07h','08h','09h','10h','11h','12h','13h','14h','15h','16h','17h','18h','19h','20h','21h','22h','23h'];
      const workload = safeParse(<?php echo json_encode(isset($workLoadStats['total']) ? $workLoadStats['total'] : []); ?>);

      new Chart(ctx, {
        type:'bar',
        data:{ labels: wlLabels, datasets:[ { label:'Chats por hora', data: workload, backgroundColor: palette.blue, borderColor: palette.blue, borderWidth:2, borderRadius:6 } ] },
        options: {
    responsive: true,
    maintainAspectRatio: false,
    layout: {
        padding: 0
    },
    plugins: {
        legend: { display: false },
        datalabels: {
            anchor: 'center',
            align: 'center',
            color: '#fff',
            font: {
                weight: '700',
                size: 12
            },
            formatter: v => v > 0 ? v : ''
        }
    },
    scales: {
        x: {
            grid: { display: false },
            offset: false,
            categoryPercentage: 0.6,
            barPercentage: 0.9,
            title: {
                display: true,
                text: 'Hora del día',
                font: { size: 13, weight: '700' }
            }
        },
        y: {
            beginAtZero: true,
            title: {
                display: true,
                text: 'Cantidad de chats'
            },
            grid: {
                color: 'rgba(0,0,0,0.05)'
            }
        }
    }
},
        plugins:[ChartDataLabels]
      });
    })();

    // -------- PIE STATUS (pieStatusChart) -----------
    (function(){
      const ctx = document.getElementById('pieStatusChart')?.getContext('2d');
      if(!ctx) return;
      const totals = [
        <?php echo isset($totalRead) ? $totalRead : 0 ?>,
        <?php echo isset($sentCount) ? $sentCount : 0 ?>,
        <?php echo isset($failedCount) ? $failedCount : 0 ?>,
        <?php echo isset($deliveredCount) ? $deliveredCount : 0 ?>,
        <?php echo isset($rejectedCount) ? $rejectedCount : 0 ?>,
        <?php echo isset($pendingCount) ? $pendingCount : 0 ?>
      ];
      const labelsPie = ['Leídos','Enviado','Fallido','Entregado','Rechazado','Pendiente'];
      const bg = ['rgba(255,99,132,0.8)','rgba(54,162,235,0.8)','rgba(255,206,86,0.8)','rgba(75,192,192,0.8)','rgba(153,102,255,0.8)','rgba(46,204,113,0.8)'];

      new Chart(ctx, {
        type:'pie',
        data:{ labels:labelsPie, datasets:[ { data: totals, backgroundColor:bg, borderColor:'#fff', borderWidth:2 } ] },
        options:{
          responsive:true, maintainAspectRatio:false,
          plugins:{ legend:{ position:'right', labels:{ usePointStyle:true, padding:12, font:{ size:12, weight:'600' }, generateLabels: function(chart){ const data = chart.data; return data.labels.map((label,i)=>({ text: `${label}: ${data.datasets[0].data[i]}`, fillStyle:data.datasets[0].backgroundColor[i], index:i })); } } }, datalabels:{ color:'#fff', font:{weight:'700', size:11}, formatter:function(value, ctx){ if(value===0) return ''; let total = ctx.chart.data.datasets[0].data.reduce((a,b)=>a+b,0); return value + ' (' + ((value/total)*100).toFixed(1) + '%)'; } } }
        },
        plugins:[ChartDataLabels]
      });
    })();

    // -------- GRAFICO ESPERA (graficoEspera) -----------
    (function(){
      const ctx = document.getElementById('graficoEspera')?.getContext('2d');
      if(!ctx) return;
      const asesores = safeParse(<?php echo json_encode(isset($asesores) ? $asesores : []); ?>);
      const promediosEspera = safeParse(<?php echo json_encode(isset($promediosEspera) ? $promediosEspera : []); ?>);

      function formatTiempo(segundos){
        if(!segundos && segundos !== 0) return '';
        segundos = Number(segundos);
        if(segundos < 60) return segundos + ' seg';
        if(segundos < 3600){ const m = Math.floor(segundos/60); const s = segundos % 60; return m + ' min' + (s>0?(' ' + s + ' seg'):''); }
        const h = Math.floor(segundos/3600), rm = Math.floor((segundos%3600)/60); return h + ' h' + (rm>0?(' ' + rm + ' min'):'');
      }

      new Chart(ctx, {
        type:'bar',
        data:{ labels: asesores, datasets:[ { label:'Promedio de espera', data: promediosEspera, backgroundColor: 'rgba(54,162,235,0.85)', borderColor:'rgba(54,162,235,1)', borderWidth:1 } ] },
        options:{
          responsive:true,
          plugins:{
            legend:{ display:false },
            tooltip:{ callbacks:{ label: (c) => formatTiempo(c.raw) } },
            datalabels:{ anchor:'center', align:'center', color:'#fff', font:{weight:'700', size:11}, formatter: v => formatTiempo(v) }
          },
          scales:{ y:{ beginAtZero:true, ticks:{ callback: v => formatTiempo(v) }, title:{ display:true, text:'Tiempo de espera' } }, x:{ title:{ display:true, text:'Asesores' } } }
        },
        plugins:[ChartDataLabels]
      });
    })();

    // -------- PIE AGENTS (pieChartAgents) -----------
    (function(){
      const ctx = document.getElementById('pieChartAgents')?.getContext('2d');
      if(!ctx) return;
      const agentNames = safeParse(<?php echo json_encode(isset($agentNames) ? $agentNames : []); ?>);
      const messageCounts = safeParse(<?php echo json_encode(isset($messageCounts) ? $messageCounts : []); ?>);
      const bgColors = ['rgba(128,0,128,0.7)','rgba(54,162,235,0.7)','rgba(255,99,132,0.7)','rgba(255,206,86,0.7)','rgba(75,192,192,0.7)','rgba(153,102,255,0.7)'];

      new Chart(ctx, {
        type:'pie',
        data:{ labels: agentNames, datasets:[ { data: messageCounts, backgroundColor: bgColors, borderColor:'#fff', borderWidth:2 } ] },
        options: {
    responsive: true,
    maintainAspectRatio: false,
    layout: {
        padding: 0
    },
    plugins: {
        legend: {
            position: 'right',
            labels: {
                usePointStyle: true,
                padding: 12,
                font: {
                    size: 12,
                    weight: '600'
                },
                generateLabels: function(chart) {
                    const d = chart.data;
                    return d.labels.map((label, i) => ({
                        text: `${label}: ${d.datasets[0].data[i]}`,
                        fillStyle: d.datasets[0].backgroundColor[i],
                        index: i
                    }));
                }
            }
        },
        datalabels: {
            color: '#fff',
            font: {
                weight: '700',
                size: 11
            },
            formatter: function(value, ctx) {
                let total = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                return value + ' (' + ((value / total) * 100).toFixed(1) + '%)';
            }
        }
    }
},
        plugins:[ChartDataLabels]
      });
    })();

    // -------- READ CHART (myChartRead) -----------
    (function(){
      const ctx = document.getElementById('myChartRead')?.getContext('2d');
      if(!ctx) return;
      const readPer = safeParse(<?php echo json_encode(isset($readPerDay) ? $readPerDay : []); ?>);
      const readData = mergeMessagesIntoDataset(labels, readPer, messagesPerDay);

      new Chart(ctx, {
        type:'bar',
        data:{ labels: labels, datasets:[ { label:'Leídas', data: readData, backgroundColor: 'rgba(255,206,86,0.9)', borderColor:'rgba(255,206,86,1)', borderWidth:2, borderRadius:6 } ] },
       options: {
    ...baseOptions('Leídas'),
    maintainAspectRatio: false,
    layout: {
        padding: 0
    },
    plugins: {
        ...baseOptions('Leídas').plugins,
        datalabels: {
            anchor: 'center',
            align: 'center',
            color: '#111',
            font: {
                weight: '700',
                size: 12
            },
            formatter: v => v > 0 ? v : ''
        }
    },
    scales: {
        x: {
            ...(baseOptions('Leídas').scales?.x || {}),
            grid: { display: false },
            offset: false,
            categoryPercentage: 0.6,
            barPercentage: 0.9
        },
        y: {
            ...(baseOptions('Leídas').scales?.y || {}),
            beginAtZero: true,
            grid: {
                color: 'rgba(0,0,0,0.05)'
            }
        }
    }
},
        plugins:[ChartDataLabels]
      });
    })();

    // -------- GENERATED CHART (myChartGenerated) -----------
    (function(){
      const ctx = document.getElementById('myChartGenerated')?.getContext('2d');
      if(!ctx) return;
      const genPerDay = safeParse(<?php echo json_encode(isset($generatedConversationPerDay) ? $generatedConversationPerDay : []); ?>);
      const genData = mergeMessagesIntoDataset(labels, genPerDay, messagesPerDay);

      new Chart(ctx, {
        type:'bar',
        data:{ labels: labels, datasets:[ { label:'Conversaciones generadas', data: genData, backgroundColor: palette.teal, borderColor: 'rgba(75,192,192,1)', borderWidth:2, borderRadius:6 } ] },
        options: {
    ...baseOptions('Conversaciones generadas'),
    maintainAspectRatio: false,
    layout: {
        padding: 0
    },
    scales: {
        ...baseOptions('Conversaciones generadas').scales,
        x: {
            ...(baseOptions('Conversaciones generadas').scales?.x || {}),
            offset: false
        },
        y: {
            ...(baseOptions('Conversaciones generadas').scales?.y || {}),
            beginAtZero: true
        }
    },
    plugins: {
        ...baseOptions('Conversaciones generadas').plugins,
        datalabels: {
            anchor: 'center',
            align: 'center',
            color: '#fff',
            font: {
                weight: '700',
                size: 12
            },
            formatter: v => v > 0 ? v : ''
        }
    }
},

        plugins:[ChartDataLabels]
      });
    })();

    // -------- ENGAGEMENT CHART (myChartEngagement) -----------
    (function(){
      const ctx = document.getElementById('myChartEngagement')?.getContext('2d');
      if(!ctx) return;
      const engagementValues = safeParse(<?php echo json_encode(isset($engagementValues) ? $engagementValues : []); ?>);
      const engData = mergeMessagesIntoDataset(labels, engagementValues, messagesPerDay);

      new Chart(ctx, {
        type:'bar',
        data:{ labels: labels, datasets:[ { label:'Engagement', data: engData, backgroundColor: 'rgba(54,162,235,0.85)', borderColor:'rgba(54,162,235,1)', borderWidth:2, borderRadius:6 } ] },
        options: {
    responsive: true,
    maintainAspectRatio: false,
    layout: {
        padding: 0
    },
    scales: {
        x: {
            offset: false
        },
        y: {
            beginAtZero: true
        }
    }
},
        plugins:[ChartDataLabels]
      });
    })();

    // -------- Indicator forms date sync -----------
    document.addEventListener('DOMContentLoaded', function(){
      const dateForm = document.getElementById('dateForm');
      const startDateField = document.getElementById('startDate');
      const endDateField = document.getElementById('endDate');
      const indicatorForms = document.querySelectorAll('.indicatorForm');

      function updateIndicatorForms(){
        const startDate = startDateField.value;
        const endDate = endDateField.value;
        indicatorForms.forEach(function(form){
          const s = form.querySelector('.startDate');
          const e = form.querySelector('.endDate');
          if(s) s.value = startDate;
          if(e) e.value = endDate;
        });
      }

      // update on change and before submitting each indicator form
      startDateField.addEventListener('change', updateIndicatorForms);
      endDateField.addEventListener('change', updateIndicatorForms);
      indicatorForms.forEach(function(form){
        form.addEventListener('submit', function(){ updateIndicatorForms(); });
      });

      // initial populate
      updateIndicatorForms();
    });

  })();
</script>
