<div class="panel">
    <h1 style="margin-bottom:20px; font-size:22px; padding-bottom:8px;">
        📊 Listado de Campañas SMS
    </h1>

    <!-- 🔹 Panel de filtros -->
<form method="get" style="margin-bottom:20px; padding:15px; border:1px solid; border-radius:6px;">
    <div style="display:flex; flex-wrap:wrap; gap:15px; align-items:flex-end;">

        <div style="flex:1;">
            <label style="font-weight:bold;">🔍 Nombre</label>
            <input type="text" name="filter_name" value="<?= htmlspecialchars($inputName ?? '') ?>"
                   class="form-control" placeholder="Buscar por nombre" />
        </div>

        <div>
            <label style="font-weight:bold;">📌 Estado</label>
            <select name="filter_status" class="form-control">
                <option value="">-- Todos --</option>
                <option value="pending" <?= ($inputStatus === 'pending') ? 'selected' : '' ?>>Pendiente</option>
                <option value="sent" <?= ($inputStatus === 'sent') ? 'selected' : '' ?>>Enviada</option>
                <option value="failed" <?= ($inputStatus === 'failed') ? 'selected' : '' ?>>Fallida</option>
            </select>
        </div>

        <div>
            <label style="font-weight:bold;">📅 Desde</label>
            <input type="date" name="from_date" value="<?= htmlspecialchars($inputFromDate ?? '') ?>"
                   class="form-control" />
        </div>

        <div>
            <label style="font-weight:bold;">📅 Hasta</label>
            <input type="date" name="to_date" value="<?= htmlspecialchars($inputToDate ?? '') ?>"
                   class="form-control" />
        </div>

        <div style="display:flex; gap:8px;">
            <!-- Botón Filtrar -->
            <button type="submit"
                    class="btn btn-sm btn-outline-primary"
                    style="display:flex; align-items:center; gap:4px; transition: all 0.2s;">
                <span class="material-icons" style="font-size:18px;">search</span> Filtrar
            </button>

            <!-- Botón Reset -->
            <a href="<?= erLhcoreClassDesign::baseurl('fbmessenger/list_campaign_sms') ?>"
               class="btn btn-sm btn-outline-secondary"
               style="display:flex; align-items:center; gap:4px; transition: all 0.2s;">
                <span class="material-icons" style="font-size:18px;">autorenew</span> Limpiar
            </a>
        </div>
    </div>
</form>

    <!-- Botón nueva campaña -->
    <div style="margin-bottom:12px;">
        <a href="<?= erLhcoreClassDesign::baseurl('fbmessenger/campaignsms') ?>"
           class="btn btn-sm btn-outline-success"
           style="display:inline-flex; align-items:center; gap:6px; transition: all 0.2s;">
            <span class="material-icons" style="font-size:18px;">add_circle</span>
            Crear campaña
        </a>
    </div>

    <?php if (!empty($items)) : ?>
        <table cellpadding="0" cellspacing="0" class="table table-sm" width="100%" ng-non-bindable>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Mensaje</th>
                    <th>Estado</th>
                    <th>Programada</th>
                    <th>Enviada</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item) : ?>
                    <tr>
                        <td><?= htmlspecialchars($item->id); ?></td>
                        <td><?= htmlspecialchars($item->name); ?></td>
                        <td style="max-width:350px; word-wrap:break-word;"><?= htmlspecialchars($item->message); ?></td>
                        <td>
                            <?php if ($item->status === 'sent'): ?>
                                <span class="badge bg-success">✔ Enviada</span>
                            <?php elseif ($item->status === 'pending'): ?>
                                <span class="badge bg-warning">Pendiente</span>
                            <?php else: ?>
                                <span class="badge bg-danger"><?= htmlspecialchars($item->status) ?></span>
                            <?php endif; ?>
                        </td>
                        <td><?= $item->scheduled_at > 0 ? date('Y-m-d H:i', $item->scheduled_at) : '<span style="">-</span>' ?></td>
                        <td><?= $item->sent_at > 0 ? date('Y-m-d H:i', $item->sent_at) : '<span style="">-</span>' ?></td>
                        <td style="display:flex; gap:6px; align-items:center;">
                            <!-- Botón Eliminar -->
                            <form method="post" action="<?= erLhcoreClassDesign::baseurl('fbmessenger/list_campaign_sms') ?>" style="display:inline;">
                                <input type="hidden" name="campaign_id_delete" value="<?= $item->id ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                    style="display:flex; align-items:center; gap:4px; transition: all 0.2s;"
                                    onclick="return confirm('¿Seguro que deseas eliminar esta campaña?')">
                                    <span class="material-icons" style="font-size:16px;">delete</span>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Paginador (HTML generado en controlador) -->
        <?php echo $paginationHtml; ?>

    <?php else: ?>
        <div style="margin-top:20px; padding:15px; border:1px solid; border-radius:6px; text-align:center;">
            No hay campañas registradas todavía 📭
        </div>
    <?php endif; ?>
</div>
