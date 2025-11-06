<style>
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
        color: white;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .table td,
    .table th {
        vertical-align: middle !important;
    }

    .status-ok { color: green; font-weight: bold; }
    .status-ko { color: red; font-weight: bold; }
    .status-mb { color: gray; font-weight: bold; }
</style>

<div class="card" style="padding:20px; border-radius:12px; background:#f9f9f9;">
    <h3 style="margin-bottom:10px;">
        <span style="color:#007bff;">📧</span> Validador de Emails
    </h3>
    <p>Introduce uno o varios correos electrónicos (separados por coma o salto de línea):</p>

    <form method="POST" enctype="multipart/form-data" style="margin-bottom:20px;">
        <textarea name="emails" rows="4" class="form-control" placeholder="usuario@dominio.com, contacto@empresa.com"><?php echo htmlspecialchars($emailsInput ?? '') ?></textarea>

        <div style="margin-top:10px;">
            <label for="csv_file"><strong>O importa un archivo CSV:</strong></label>
            <input type="file" name="csv_file" id="csv_file" accept=".csv" class="form-control" style="margin-top:5px;">
            <small style="color:gray;">Formato: debe tener una columna llamada <code>EMAIL</code></small>
        </div>

        <button type="submit" class="btn btn-primary mt-2">Validar / Importar</button>
    </form>

    <?php if (isset($error)): ?>
        <div style="color:red; font-weight:bold; margin-top:10px;"><?php echo htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if (isset($results)): ?>
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h4>Resultados:</h4>
            <button id="exportCsv" class="btn btn-success btn-sm">📤 Exportar CSV</button>
        </div>

        <table id="resultsTable" class="table table-bordered" style="background:white; border-radius:8px; overflow:hidden; margin-top:10px;">
            <thead style="background:#007bff; color:white;">
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
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'validacion_emails.csv';
    link.click();
});
</script>
