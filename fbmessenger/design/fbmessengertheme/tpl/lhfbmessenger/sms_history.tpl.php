<div class="panel">
    <h1 style="margin-bottom:20px; font-size:22px; color:#333; padding-bottom:8px;">
        📜 Historial de SMS
    </h1>

    <!-- 🔍 Panel de filtros -->
    <form method="get" style="margin-bottom:20px; padding:15px; background:#f8f9fa; border:1px solid #ddd; border-radius:6px;">
        <div style="display:flex; flex-wrap:wrap; gap:15px; align-items:flex-end;">

            <div style="flex:1;">
                <label style="font-weight:bold; color:#555;">📱 Teléfono</label>
                <input type="text" name="phone" value="<?= htmlspecialchars($_GET['phone'] ?? '') ?>"
                    class="form-control" placeholder="+57300..." />
            </div>

            <div>
                <label style="font-weight:bold; color:#555;">📌 Estado</label>
                <select name="status" class="form-control">
                    <option value="">-- Todos --</option>
                    <option value="sent" <?= (($_GET['status'] ?? '') === 'sent') ? 'selected' : '' ?>>✔ Enviado</option>
                    <option value="failed" <?= (($_GET['status'] ?? '') === 'failed') ? 'selected' : '' ?>>❌ Fallido</option>
                </select>
            </div>

            <div>
                <label style="font-weight:bold; color:#555;">📅 Desde</label>
                <input type="date" name="from_date" value="<?= htmlspecialchars($_GET['from_date'] ?? '') ?>"
                    class="form-control" />
            </div>

            <div>
                <label style="font-weight:bold; color:#555;">📅 Hasta</label>
                <input type="date" name="to_date" value="<?= htmlspecialchars($_GET['to_date'] ?? '') ?>"
                    class="form-control" />
            </div>

            <div style="display:flex; gap:8px;">

                <!-- Botón Filtrar -->
                <button type="submit" class="btn btn-sm btn-outline-primary" style="display:flex; align-items:center; gap:4px; transition: all 0.2s;">
                    <span class="material-icons" style="font-size:18px;">search</span> Filtrar
                </button>

                <!-- Botón Reset -->
                <a href="<?= erLhcoreClassDesign::baseurl('fbmessenger/sms_history') ?>"
                    class="btn btn-sm btn-outline-secondary"
                    style="display:flex; align-items:center; gap:4px; transition: all 0.2s;">
                    <span class="material-icons" style="font-size:18px;">autorenew</span> Reset
                </a>

            </div>
        </div>
    </form>

    <?php if (!empty($messages)) : ?>
        <table cellpadding="0" cellspacing="0" class="table table-sm" width="100%" ng-non-bindable>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Teléfono</th>
                    <th>Mensaje</th>
                    <th>Message ID</th>
                    <th>Estado</th>
                    <th>Error</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <?php foreach ($messages as $msg) : ?>
                <tr>
                    <td><?= htmlspecialchars($msg->id); ?></td>
                    <td><?= htmlspecialchars($msg->phone); ?></td>
                    <td style="max-width:350px; word-wrap:break-word;"><?= htmlspecialchars($msg->message); ?></td>
                    <td><?= htmlspecialchars($msg->message_id); ?></td>
                    <td>
                        <?php if ($msg->status == 'sent') : ?>
                            <span class="badge bg-success">✔ Enviado</span>
                        <?php else : ?>
                            <span class="badge bg-danger">❌ Fallido</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?= !empty($msg->error) ? htmlspecialchars($msg->error) : '<span style="color:#777;">-</span>'; ?>
                    </td>
                    <td><?= date('Y-m-d H:i:s', $msg->created_at); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else : ?>
        <div style="margin-top:20px; padding:15px; background:#f8f9fa; border:1px solid #ddd; border-radius:6px; text-align:center; color:#555;">
            No hay mensajes registrados todavía 📭
        </div>
    <?php endif; ?>
    <?php echo $paginationHtml; ?>

</div>