<h2 style="margin-bottom:20px; display:flex;align-items:center;gap:8px;">
    📲 Enviar SMS Individual
</h2>

<?php if (isset($response)): ?>
    <?php if (!empty($response['success'])): ?>
        <div style="background:#d4edda;color:#155724;border:1px solid #c3e6cb;
                    padding:12px;border-radius:6px;margin-bottom:20px;font-weight:500;">
            ✅ SMS enviado correctamente.<br>
            <strong>MessageId:</strong> <?= htmlspecialchars($response['messageId']); ?><br>
            <strong>Teléfono:</strong> <?= htmlspecialchars($response['phone']); ?>
        </div>
    <?php else: ?>
        <div style="background:#f8d7da;color:#721c24;border:1px solid #f5c6cb;
                    padding:12px;border-radius:6px;margin-bottom:20px;font-weight:500;">
            ❌ Error al enviar SMS.<br>
            <strong>Teléfono:</strong> <?= htmlspecialchars($response['phone']); ?><br>
            <strong>Detalle:</strong> <?= htmlspecialchars($response['error']); ?>
        </div>
    <?php endif; ?>
<?php endif; ?>

<form method="post"
    style="max-width:600px;background:#fff;border:1px solid #ddd;padding:20px;border-radius:8px;
           box-shadow:0 2px 6px rgba(0,0,0,0.05);">

    <div style="margin-bottom:15px;">
        <label style="font-weight:bold;display:block;margin-bottom:6px;">📞 Teléfono (+57300...)</label>
        <input type="text" name="phone"
            value="<?= htmlspecialchars($_POST['phone'] ?? '', ENT_QUOTES); ?>"
            placeholder="+573001112233"
            style="display:block;width:100%;padding:10px;border:1px solid #ccc;border-radius:5px;
                   box-sizing:border-box;">
    </div>

    <div style="margin-bottom:20px;">
        <label style="font-weight:bold;display:block;margin-bottom:6px;">💬 Mensaje</label>
        <textarea name="message" cols="0"
            style="display:block;width:100%;min-height:120px;padding:10px;border:1px solid #ccc;
                   border-radius:5px;box-sizing:border-box;resize:vertical;"><?= htmlspecialchars($_POST['message'] ?? '', ENT_QUOTES); ?></textarea>
    </div>

    <button type="submit" name="send"
        class="btn btn-sm btn-outline-primary"
        style="display:flex; align-items:center; gap:6px; border-radius:6px; padding:10px 20px; transition: all 0.2s; cursor:pointer;">
        <span class="material-icons" style="font-size:18px;">send</span> Enviar SMS
    </button>

</form>