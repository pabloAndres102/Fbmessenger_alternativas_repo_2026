<h2 class="fs-4 mb-3 d-flex align-items-center gap-2">
    📲 Enviar SMS Individual
</h2>

<?php if (isset($response)): ?>
    <?php if (!empty($response['success'])): ?>
        <div class="alert alert-success mb-3">
            ✅ SMS enviado correctamente.<br>
            <strong>MessageId:</strong> <?= htmlspecialchars($response['messageId']); ?><br>
            <strong>Teléfono:</strong> <?= htmlspecialchars($response['phone']); ?>
        </div>
    <?php else: ?>
        <div class="alert alert-danger mb-3">
            ❌ Error al enviar SMS.<br>
            <strong>Teléfono:</strong> <?= htmlspecialchars($response['phone']); ?><br>
            <strong>Detalle:</strong> <?= htmlspecialchars($response['error']); ?>
        </div>
    <?php endif; ?>
<?php endif; ?>

<form method="post" class="card p-4 shadow-sm" style="max-width:600px;">
    <div class="mb-3">
        <label class="form-label fw-bold">📞 Teléfono (+57300...)</label>
        <input type="text" name="phone"
               value="<?= htmlspecialchars($_POST['phone'] ?? '', ENT_QUOTES); ?>"
               placeholder="+573001112233"
               class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label fw-bold">💬 Mensaje</label>
        <textarea name="message" rows="4"
                  class="form-control"
                  placeholder="Escribe tu mensaje aquí..."><?= htmlspecialchars($_POST['message'] ?? '', ENT_QUOTES); ?></textarea>
    </div>

    <button type="submit" name="send"
            class="btn btn-outline-primary d-flex align-items-center gap-2">
        <span class="material-icons" style="font-size:18px;">send</span>
        Enviar SMS
    </button>
</form>
