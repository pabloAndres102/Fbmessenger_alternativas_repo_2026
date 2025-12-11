<style>
    .request-counter-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 18px 22px;
        border-radius: 16px;
        font-weight: bold;
        margin-bottom: 20px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, .18);
        animation: counterFadeIn .4s ease;
    }

    .counter-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .counter-icon {
        font-size: 36px;
    }

    .counter-info {
        display: flex;
        flex-direction: column;
    }

    .progress-wrap {
        width: 100%;
        height: 10px;
        background: rgba(255, 255, 255, .25);
        border-radius: 50px;
        overflow: hidden;
        margin-top: 8px;
    }

    .progress-bar {
        height: 100%;
        background: #fff;
        border-radius: 50px;
        transition: width .4s ease;
    }

    .progress-warning .progress-bar {
        background: #ffc107;
    }

    .progress-danger .progress-bar {
        background: #ff4d4d;
    }

    .limit-badge {
        background: rgba(0, 0, 0, .25);
        padding: 8px 14px;
        border-radius: 50px;
        font-size: 13px;
        text-align: right;
    }

    textarea.form-control {
        width: 100%;
        border-radius: 8px;
        border: 1px solid #ccc;
        padding: 10px;
        resize: vertical;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
        border-radius: 6px;
        padding: 8px 16px;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-success {
        background-color: #28a745;
        border: none;
        border-radius: 6px;
        padding: 6px 12px;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .table td,
    .table th {
        vertical-align: middle !important;
    }

    .status-ok {
        color: green;
        font-weight: bold;
    }

    .status-ko {
        color: red;
        font-weight: bold;
    }

    .status-mb {
        color: gray;
        font-weight: bold;
    }

    .email-counter {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #eef4ff;
        border: 1px solid #d6e0ff;
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 14px;
        margin-bottom: 15px;
    }

    .email-counter .progress {
        width: 100%;
        height: 8px;
        background: #ddd;
        border-radius: 5px;
        overflow: hidden;
        margin-top: 6px;
    }

    .email-counter .bar {
        height: 100%;
        background: #007bff;
        transition: width .3s ease;
    }

    .email-counter .limit {
        font-weight: bold;
        color: #007bff;
    }
</style>

<div class="card" style="padding:20px; border-radius:12px;">
    <?php if (!empty($no_access)): ?>
        <div style="
        background:#fff3f3;
        color:#a10000;
        padding:20px;
        border-radius:14px;
        font-weight:600;
        text-align:center;
        box-shadow:0 5px 20px rgba(0,0,0,.05);
    ">
            ⛔ No tienes permisos para usar el validador de emails.<br>
            Contacta al administrador.
        </div>
        <?php return; ?>
    <?php endif; ?>

    <?php
    $used  = (int)($emailRequestCount ?? 0);
    $limit = (int)($emailLimit ?? 50000);
    $month = htmlspecialchars($currentMonth ?? date('Y-m'));
    $percent = min(100, ($used / max($limit, 1)) * 100);

    $progressClass = '';
    if ($percent >= 90) {
        $progressClass = 'progress-danger';
    } elseif ($percent >= 75) {
        $progressClass = 'progress-warning';
    }
    ?>

    <div class="request-counter-card" style="background: linear-gradient(135deg,#4facfe,#00f2fe);">
        <div class="counter-left">
            <div class="counter-icon">📧</div>

            <div class="counter-info">
                <div class="counter-title">Validaciones de email usadas este mes</div>

                <div class="counter-number">
                    <?php echo number_format($used); ?> / <?php echo number_format($limit); ?>
                </div>

                <div class="progress-wrap <?php echo $progressClass; ?>">
                    <div class="progress-bar" style="width: <?php echo $percent; ?>%;"></div>
                </div>

                <div class="counter-limit">
                    Límite mensual activo: <strong><?php echo number_format($limit); ?></strong> validaciones
                </div>
            </div>
        </div>

        <div class="limit-badge">
            📅 Mes activo<br>
            <strong><?php echo $month; ?></strong>
        </div>
    </div>



    <h3 style="margin-bottom:10px;">
        <span>📧</span> Validador de Emails
    </h3>
    <p>Introduce uno o varios correos electrónicos (separados por coma o salto de línea):</p>

    <form method="POST" enctype="multipart/form-data" style="margin-bottom:20px;">
        <textarea name="emails" rows="4" class="form-control" placeholder="usuario@dominio.com, contacto@empresa.com"><?php echo htmlspecialchars($emailsInput ?? '') ?></textarea>

        <div style="margin-top:10px;">
            <label for="csv_file"><strong>O importa un archivo CSV:</strong></label>
            <input type="file" name="csv_file" id="csv_file" accept=".csv" class="form-control" style="margin-top:5px;">
            <small>Formato: debe tener una columna llamada <code>EMAIL</code></small>
        </div>

        <button type="submit" class="btn btn-primary mt-2">Validar / Importar</button>
    </form>

    <?php if (isset($error)): ?>
        <div style="font-weight:bold; margin-top:10px;"><?php echo htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if (isset($results)): ?>
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h4>Resultados:</h4>
            <button id="exportCsv" class="btn btn-success btn-sm">📤 Exportar CSV</button>
        </div>

        <table id="resultsTable" class="table table-bordered" style="background:white; border-radius:8px; overflow:hidden; margin-top:10px;">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Estado</th>
                    <th>Mensaje</th>
                    <th>Dominio</th>
                    <th>Servidor</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $res): ?>
                    <?php
                    $code = strtolower($res['code']);
                    $statusClass = $code === 'ok' ? 'status-ok' : ($code === 'ko' ? 'status-ko' : 'status-mb');
                    $statusText = $code === 'ok' ? '🟢 Válido' : ($code === 'ko' ? '🔴 Inválido' : '⚪ Indeterminado');
                    ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($res['email']) ?></strong></td>
                        <td class="<?php echo $statusClass; ?>" style="text-align:center;"><?php echo $statusText; ?></td>
                        <td><?php echo htmlspecialchars($res['message'] ?? '') ?></td>
                        <td><?php echo htmlspecialchars($res['domain'] ?? '') ?></td>
                        <td><?php echo htmlspecialchars($res['mx'] ?? '') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<script>
    document.getElementById('exportCsv')?.addEventListener('click', function() {
        const rows = [];
        const table = document.getElementById('resultsTable');
        rows.push(['EMAIL', 'ESTADO', 'MENSAJE', 'DOMINIO', 'SERVIDOR']);

        table.querySelectorAll('tbody tr').forEach(tr => {
            const email = tr.cells[0]?.innerText.trim() || '';
            const estado = tr.cells[1]?.innerText.trim().replace(/[^\w\s]/gi, '').trim() || '';
            const mensaje = tr.cells[2]?.innerText.trim() || '';
            const dominio = tr.cells[3]?.innerText.trim() || '';
            const servidor = tr.cells[4]?.innerText.trim() || '';
            rows.push([email, estado, mensaje, dominio, servidor]);
        });

        const csvContent = rows.map(e => e.map(v => `"${v.replace(/"/g, '""')}"`).join(',')).join('\n');
        const blob = new Blob([csvContent], {
            type: 'text/csv;charset=utf-8;'
        });
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = 'validacion_emails.csv';
        link.click();
    });
</script>