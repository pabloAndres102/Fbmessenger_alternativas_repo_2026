<div class="container py-5 text-center">

    <h2 class="mb-4">🔕 Cancelar Suscripción</h2>

    <?php if ($response['success']): ?>
        <div class="alert alert-success">
            ✅ Has sido desuscrito correctamente del canal.<br>
            <strong>Teléfono:</strong> <?= htmlspecialchars($response['phone']) ?>
        </div>
    <?php else: ?>
        <div class="alert alert-danger">
            ❌ No se pudo procesar tu solicitud.<br>
            <strong>Motivo:</strong> <?= htmlspecialchars($response['error']) ?>
        </div>
    <?php endif; ?>
</div>
