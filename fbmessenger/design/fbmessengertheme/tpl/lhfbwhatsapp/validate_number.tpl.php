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
</style>


<div class="card" style="padding:20px; border-radius:12px; background:#f9f9f9;">
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

        // 🔹 Agregar encabezados personalizados
        rows.push(['NUMERO', 'ESTADO']);

        // 🔹 Recorrer filas del cuerpo de la tabla
        table.querySelectorAll('tbody tr').forEach(tr => {
            const number = tr.cells[0]?.innerText.trim() || '';
            let estado = tr.cells[1]?.innerText.trim() || '';

            // Simplificar valores visuales como 🟢 Válido o 🔴 Inválido
            if (estado.includes('Válido')) estado = 'Válido';
            else if (estado.includes('Inválido')) estado = 'Inválido';
            else estado = estado.replace(/[^\w\s]/gi, '').trim() || 'Desconocido';

            rows.push([number, estado]);
        });

        // 🔹 Convertir a CSV
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