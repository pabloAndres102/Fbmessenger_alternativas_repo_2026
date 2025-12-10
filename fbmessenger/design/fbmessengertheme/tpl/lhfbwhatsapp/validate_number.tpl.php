<style>
    /* -----------------------------------
       Contador de peticiones (estilo)
    ----------------------------------- */
    .request-counter-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 18px 22px;
        border-radius: 16px;
        background: linear-gradient(135deg, #25D366, #128C7E);
        color: #fff;
        font-weight: bold;
        margin-bottom: 20px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.18);
        animation: counterFadeIn 0.4s ease;
    }

    .counter-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .counter-icon {
        font-size: 36px;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
    }

    .counter-info {
        display: flex;
        flex-direction: column;
        line-height: 1.2;
    }

    .counter-title {
        font-size: 13px;
        letter-spacing: 1px;
        opacity: 0.95;
        text-transform: uppercase;
    }

    .counter-number {
        font-size: 30px;
        font-weight: 800;
        letter-spacing: 2px;
    }

    .counter-limit {
        font-size: 12px;
        opacity: 0.95;
    }

    /* Barra de progreso */
    .progress-wrap {
        width: 100%;
        height: 10px;
        background: rgba(255, 255, 255, 0.25);
        border-radius: 50px;
        overflow: hidden;
        margin-top: 8px;
    }

    .progress-bar {
        height: 100%;
        background: #ffffff;
        border-radius: 50px;
        transition: width 0.4s ease;
    }

    /* Estados */
    .progress-warning .progress-bar {
        background: #ffc107;
    }

    .progress-danger .progress-bar {
        background: #ff4d4d;
    }

    .limit-badge {
        background: rgba(0, 0, 0, 0.25);
        padding: 8px 14px;
        border-radius: 50px;
        font-size: 13px;
        text-align: right;
        white-space: nowrap;
    }

    @keyframes counterFadeIn {
        from {
            opacity: 0;
            transform: translateY(6px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
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
        color: white;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .table td,
    .table th {
        vertical-align: middle !important;
    }
</style>

<div class="card" style="padding:20px; border-radius:12px; background:#f9f9f9;">
    



    <?php
    $used = (int)($requestCount ?? 0);
    $limit = (int)($monthLimit ?? 5000);
    $month = htmlspecialchars($currentMonth ?? date('Y-m'));
    $percent = min(100, ($used / $limit) * 100);

    $progressClass = '';
    if ($percent >= 90) {
        $progressClass = 'progress-danger';
    } elseif ($percent >= 75) {
        $progressClass = 'progress-warning';
    }
    ?>

    <!-- Tarjeta contador -->
    <div class="request-counter-card">
        <div class="counter-left">
            <div class="counter-icon">⚡</div>
            <div class="counter-info">
                <div class="counter-title">Validaciones usadas este mes</div>
                <div class="counter-number">
                    <?php echo $used; ?> / <?php echo $limit; ?>
                </div>
                <div class="progress-wrap <?php echo $progressClass; ?>">
                    <div class="progress-bar" style="width: <?php echo $percent; ?>%;"></div>
                </div>
                <div class="counter-limit">Límite mensual activo: <strong><?php echo $limit; ?></strong> validaciones</div>
            </div>
        </div>

        <div class="limit-badge">
            📅 Mes activo<br>
            <strong><?php echo $month; ?></strong>
        </div>
    </div>

    <h3 style="margin-bottom:10px;">
        <span style="color:#25D366;">📞</span> Validar números de WhatsApp
    </h3>
    <p>Introduce uno o varios números (separados por coma o salto de línea):</p>

    <form method="POST" enctype="multipart/form-data" style="margin-bottom:20px;">
        <textarea name="numbers" rows="4" class="form-control" placeholder="+573001112233, +573224445566"><?php echo htmlspecialchars($numbersInput ?? '') ?></textarea>

        <div style="margin-top:10px;">
            <label for="csv_file"><strong>O importa un archivo CSV:</strong></label>
            <input type="file" name="csv_file" id="csv_file" accept=".csv" class="form-control" style="margin-top:5px;">
            <small style="color:gray;">Formato: solo una columna llamada <code>NUMERO</code></small>
        </div>

        <button type="submit" class="btn btn-primary mt-2">Validar / Importar</button>
    </form>

    <?php if (isset($error)): ?>
        <div style="color:red; font-weight:bold; margin-top:10px;"><?php echo htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if (isset($results)) : ?>
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h4>Resultados:</h4>
            <button id="exportCsv" class="btn btn-success btn-sm">📤 Exportar CSV</button>
        </div>

        <table id="resultsTable" class="table table-bordered" style="background:white; border-radius:8px; overflow:hidden; margin-top:10px;">
            <thead style="background:#007bff; color:white;">
                <tr>
                    <th>Número</th>
                    <th>Estado</th>
                    <th>Mensaje</th>
                    <th>Detalles</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $res):
                    $isValid = strtolower($res['details']['status'] ?? '') === 'valid';
                ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($res['number']) ?></strong></td>
                        <td style="text-align:center;">
                            <?php if ($isValid): ?>
                                <span style="color:green; font-weight:bold;">🟢 Válido</span>
                            <?php elseif (strtolower($res['details']['status'] ?? '') === 'invalid'): ?>
                                <span style="color:red; font-weight:bold;">🔴 Inválido</span>
                            <?php else: ?>
                                <span style="color:gray;">⚪ <?php echo htmlspecialchars($res['status']) ?></span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($res['message'] ?? '') ?></td>
                        <td>
                            <?php echo $isValid ? 'Válido' : 'Inválido'; ?>
                        </td>
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

        rows.push(['NUMERO', 'ESTADO']);

        table.querySelectorAll('tbody tr').forEach(tr => {
            const number = tr.cells[0]?.innerText.trim() || '';
            let estado = tr.cells[1]?.innerText.trim() || '';

            if (estado.includes('Válido')) estado = 'Válido';
            else if (estado.includes('Inválido')) estado = 'Inválido';
            else estado = estado.replace(/[^\w\s]/gi, '').trim() || 'Desconocido';

            rows.push([number, estado]);
        });

        const csvContent = rows.map(e => e.map(v => `"${v.replace(/"/g, '""')}"`).join(',')).join('\n');
        const blob = new Blob([csvContent], {
            type: 'text/csv;charset=utf-8;'
        });

        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = 'validacion_numeros.csv';
        link.click();
    });
</script>