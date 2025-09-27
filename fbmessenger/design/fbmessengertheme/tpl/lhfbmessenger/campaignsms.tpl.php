<style>
/* ====== Estilos generales ====== */
.page-container {
    font-family: "Segoe UI", Roboto, Arial, sans-serif;
    color: #333;
}

/* ====== Resumen tarjetas ====== */
.summary-cards {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 25px;
}
.summary-card {
    flex: 1;
    min-width: 160px;
    background: #fff;
    border-radius: 10px;
    padding: 18px;
    text-align: center;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    transition: transform 0.2s;
}
.summary-card:hover {
    transform: translateY(-3px);
}
.summary-card .icon {
    font-size: 1.8em;
    margin-bottom: 10px;
}
.summary-card .value {
    font-weight: bold;
    font-size: 1.2em;
}
.summary-card .label {
    color: #666;
    font-size: 0.85em;
}

/* Colores por estado */
.bg-blue { border-top: 4px solid #007bff; }
.bg-green { border-top: 4px solid #28a745; }
.bg-orange { border-top: 4px solid #fd7e14; }
.bg-teal { border-top: 4px solid #17a2b8; }

/* ====== Formulario ====== */
.form-panel {
    background: #fff;
    border: 1px solid #ddd;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    max-width: 750px;
    margin-bottom: 30px;
}
.form-panel h2 {
    margin-bottom: 15px;
    color: #007bff;
    font-size: 1.4em;
}
.form-group {
    margin-bottom: 18px;
}
.form-group label {
    font-weight: bold;
    display: block;
    margin-bottom: 6px;
}
.form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
}
textarea.form-control {
    min-height: 100px;
}
button.btn-submit {
    background: #28a745;
    color: #fff;
    border: none;
    padding: 12px 25px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 1em;
    transition: background 0.2s;
}
button.btn-submit:hover {
    background: #218838;
}

/* ====== Resultados tabla ====== */
.results-table {
    border-collapse: collapse;
    width: 100%;
    max-width: 750px;
    margin-top: 15px;
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}
.results-table thead {
    background: #007bff;
    color: #fff;
}
.results-table th, .results-table td {
    padding: 12px;
    border: 1px solid #ddd;
    font-size: 0.95em;
}
.results-table tbody tr:nth-child(even) {
    background: #f9f9f9;
}
.results-table tbody tr:hover {
    background: #eef6ff;
}
</style>

<div class="page-container">

    <!-- Resumen -->
    <?php if (isset($campaign) && is_object($campaign) && !empty($campaign->id)) : ?>
        <div class="summary-cards">
            <div class="summary-card bg-blue">
                <div class="icon">📛</div>
                <div class="value"><?= htmlspecialchars($campaign->name) ?></div>
                <div class="label">Nombre</div>
            </div>
            <div class="summary-card bg-green">
                <div class="icon">📊</div>
                <div class="value"><?= htmlspecialchars($campaign->status) ?></div>
                <div class="label">Estado</div>
            </div>
            <?php if (!empty($campaign->scheduled_at)) : ?>
            <div class="summary-card bg-orange">
                <div class="icon">⏰</div>
                <div class="value"><?= date('Y-m-d H:i', $campaign->scheduled_at) ?></div>
                <div class="label">Programada</div>
            </div>
            <?php endif; ?>
            <?php if (!empty($campaign->sent_at)) : ?>
            <div class="summary-card bg-teal">
                <div class="icon">🚀</div>
                <div class="value"><?= date('Y-m-d H:i', $campaign->sent_at) ?></div>
                <div class="label">Enviada</div>
            </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Formulario -->
    <div class="form-panel">
        <h2>📩 Configuración de la Campaña</h2>
        <form method="post" action="">
            
            <div class="form-group">
                <label>📂 Listas de contactos</label>
                <div style="max-height:200px;overflow-y:auto;padding:10px;border:1px solid #ccc;border-radius:5px;background:#fdfdfd;">
                    <?php
                    $contactLists = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppContactList::getList();
                    $selectedLists = isset($campaign) && !empty($campaign->lists_id) ? json_decode($campaign->lists_id, true) : [];

                    if (!empty($contactLists)) {
                        foreach ($contactLists as $contactList) {
                            $isChecked = in_array($contactList->id, $selectedLists) ? 'checked' : '';
                            echo '<label style="display:flex;align-items:center;margin-bottom:6px;cursor:pointer;">';
                            echo '<input type="checkbox" name="ml[]" value="' . $contactList->id . '" ' . $isChecked . ' style="margin-right:8px;">';
                            echo '<span>' . htmlspecialchars($contactList->name) . ' <span style="color:#666;font-size:0.85em;">(' . $contactList->total_contacts . ' contactos)</span></span>';
                            echo '</label>';
                        }
                    } else {
                        echo '<div style="color:#999;font-size:0.9em;">⚠ No hay listas de contactos disponibles.</div>';
                    }
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label>💬 Mensaje</label>
                <textarea name="message" class="form-control" required><?php if (isset($campaign) && is_object($campaign)) echo htmlspecialchars($campaign->message); ?></textarea>
            </div>

            <div class="form-group">
                <label>🏷 Nombre de la campaña</label>
                <input type="text" name="campaign" class="form-control" placeholder="Ej: Promo Septiembre" 
                       value="<?php if (isset($campaign) && is_object($campaign)) echo htmlspecialchars($campaign->name); ?>" required>
            </div>

            <div class="form-group">
                <label>⏰ Fecha y hora de envío (opcional)</label>
                <input type="datetime-local" name="scheduled_at" class="form-control"
                       <?php if (isset($campaign) && is_object($campaign) && !empty($campaign->scheduled_at) && $campaign->scheduled_at > 0) {
                           echo 'value="' . date('Y-m-d\TH:i', $campaign->scheduled_at) . '"';
                       } ?> required>
                <div style="font-size:0.85em;color:#666;margin-top:6px;">Dejar vacío para enviar inmediatamente.</div>
            </div>

            <button type="submit" name="send" class="btn-submit">
                🚀 Programar Campaña
            </button>
        </form>
    </div>

    <!-- Resultados -->
    <?php if (isset($response)) : ?>
        <?php if (is_string($response)) : ?>
            <div style="margin-top:20px;padding:12px;border:1px solid #ddd;background:#f9f9f9;border-radius:5px;">
                <?= htmlspecialchars($response) ?>
            </div>
        <?php elseif (is_array($response)) : ?>
            <h3 style="margin-top:25px;">📋 Resultados de la campaña</h3>
            <table class="results-table">
                <thead>
                    <tr>
                        <th>Teléfono</th>
                        <th>Estado</th>
                        <th>Error</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($response as $res): ?>
                        <tr>
                            <td><?= htmlspecialchars($res['phone']) ?></td>
                            <td><?= htmlspecialchars($res['status']) ?></td>
                            <td><?= htmlspecialchars($res['error']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    <?php endif; ?>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var form = document.querySelector('form');
    var inputDate = form.querySelector('input[name="scheduled_at"]');

    // 🔹 Definir mínimo dinámicamente (fecha + hora actual exacta)
    var now = new Date();
    var localISOTime = new Date(now.getTime() - now.getTimezoneOffset() * 60000)
                           .toISOString().slice(0,16);
    inputDate.setAttribute("min", localISOTime);

    form.addEventListener('submit', function(e) {
        var value = inputDate.value;
        if (!value) return; // vacío = inmediato

        var scheduledDate = new Date(value);
        var nowCheck = new Date();

        // ⚠️ Normalizar quitando segundos/milisegundos para comparar
        scheduledDate.setSeconds(0, 0);
        nowCheck.setSeconds(0, 0);

        // Validar que no sea en el pasado (fecha y hora incluidas)
        if (scheduledDate.getTime() < nowCheck.getTime()) {
            alert("❌ No puedes programar una campaña en una fecha/hora pasada.");
            e.preventDefault();
            return;
        }

        // ✅ Si quieres forzar que sea al menos 1 minuto después de la hora actual
        if (scheduledDate.getTime() < nowCheck.getTime() + 60 * 1000) {
            alert("⚠️ Debes programar la campaña al menos 1 minuto después de la hora actual.");
            e.preventDefault();
            return;
        }

        // ... aquí sigue tu validación de restricciones por día
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    
    // Obtener restricciones desde PHP
    var restricciones = <?php echo json_encode([
        'monday'    => ['start' => $restricciones['campaign_monday_start'] ?? '', 'end' => $restricciones['campaign_monday_end'] ?? ''],
        'tuesday'   => ['start' => $restricciones['campaign_tuesday_start'] ?? '', 'end' => $restricciones['campaign_tuesday_end'] ?? ''],
        'wednesday' => ['start' => $restricciones['campaign_wednesday_start'] ?? '', 'end' => $restricciones['campaign_wednesday_end'] ?? ''],
        'thursday'  => ['start' => $restricciones['campaign_thursday_start'] ?? '', 'end' => $restricciones['campaign_thursday_end'] ?? ''],
        'friday'    => ['start' => $restricciones['campaign_friday_start'] ?? '', 'end' => $restricciones['campaign_friday_end'] ?? ''],
        'saturday'  => ['start' => $restricciones['campaign_saturday_start'] ?? '', 'end' => $restricciones['campaign_saturday_end'] ?? ''],
        'sunday'    => ['start' => $restricciones['campaign_sunday_start'] ?? '', 'end' => $restricciones['campaign_sunday_end'] ?? ''],
    ]); ?>;

    var form = document.querySelector('form');
    var inputDate = form.querySelector('input[name="scheduled_at"]');

    form.addEventListener('submit', function(e) {
        var value = inputDate.value;
        if (!value) return; // Vacío = enviar inmediatamente

        var scheduledDate = new Date(value);
        var days = ['sunday','monday','tuesday','wednesday','thursday','friday','saturday'];
        var dayName = days[scheduledDate.getDay()];
        var restric = restricciones[dayName];

        if (!restric || !restric.start || !restric.end) {
            alert('No hay restricción configurada para el día seleccionado: ' + dayName);
            e.preventDefault();
            return;
        }

        // Convertir horas en Date
        var startTime = new Date(scheduledDate.toDateString() + ' ' + restric.start);
        var endTime   = new Date(scheduledDate.toDateString() + ' ' + restric.end);

        if (scheduledDate < startTime || scheduledDate > endTime) {
            alert('La fecha y hora debe estar entre ' + restric.start + ' y ' + restric.end + ' para el día ' + dayName);
            e.preventDefault();
            return;
        }
    });
});
</script>
