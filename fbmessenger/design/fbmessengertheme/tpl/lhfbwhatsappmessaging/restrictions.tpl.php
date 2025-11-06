<style>
    h4 {
        font-weight: 600;
        color: var(--bs-body-color);
    }

    .table td,
    .table th {
        vertical-align: middle !important;
    }

    .table-hover tbody tr:hover {
        background-color: var(--bs-tertiary-bg);
        transition: background-color 0.2s ease;
    }

    .card {
        border-radius: 10px;
        background-color: var(--bs-body-bg);
        color: var(--bs-body-color);
    }

    .btn-success {
        background-color: var(--bs-success);
        border: none;
        border-radius: 6px;
        font-weight: 500;
        color: #fff;
        transition: background-color 0.2s ease;
    }

    .btn-success:hover {
        background-color: var(--bs-success-hover, #157347);
    }

    .input-group-text {
        background-color: var(--bs-secondary-bg);
        border-right: none;
        color: var(--bs-body-color);
    }

    .form-control {
        background-color: var(--bs-body-bg);
        color: var(--bs-body-color);
        border: 1px solid var(--bs-border-color);
    }

    .form-control:focus {
        border-color: var(--bs-primary);
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }

    .table-light,
    .table thead.table-light th {
        background-color: var(--bs-secondary-bg) !important;
        color: var(--bs-body-color) !important;
        border-color: var(--bs-border-color) !important;
        font-weight: 600;
    }



    .text-dark {
        color: var(--bs-body-color) !important;
    }
</style>
<form action="" method="post" ng-non-bindable class="p-3">

    <?php include(erLhcoreClassDesign::designtpl('lhkernel/csfr_token.tpl.php')); ?>

    <div class="d-flex align-items-center mb-3">
        <span class="material-icons text-muted me-2" style="font-size: 28px;">block</span>
        <h4 class="m-0">Restricciones de envío por día</h4>
    </div>

    <?php if (isset($updated) && $updated == 'done') : ?>
        <?php $msg = erTranslationClassLhTranslation::getInstance()->getTranslation('chat/onlineusers', 'Configuración actualizada correctamente'); ?>
        <?php include(erLhcoreClassDesign::designtpl('lhkernel/alert_success.tpl.php')); ?>
    <?php endif; ?>

    <p class="text-secondary small mb-4">
        Aquí puedes definir los horarios permitidos para enviar campañas de WhatsApp por día.
        <br>⚠️ Los mensajes fuera del rango establecido **no serán enviados automáticamente**.
    </p>

    <?php
    $dias = [
        'monday' => 'Lunes',
        'tuesday' => 'Martes',
        'wednesday' => 'Miércoles',
        'thursday' => 'Jueves',
        'friday' => 'Viernes',
        'saturday' => 'Sábado',
        'sunday' => 'Domingo'
    ];
    ?>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 30%;">Día</th>
                        <th style="width: 35%;">Hora inicio</th>
                        <th style="width: 35%;">Hora fin</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dias as $key => $label) : ?>
                        <tr>
                            <td class="fw-bold text-dark"><?php echo $label; ?></td>
                            <td>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">
                                        <span class="material-icons" style="font-size:16px;">schedule</span>
                                    </span>
                                    <input type="time" step="60" class="form-control"
                                        name="campaign_<?php echo $key; ?>_start"
                                        value="<?php echo isset($fb_options["campaign_{$key}_start"]) ?
                                                    htmlspecialchars($fb_options["campaign_{$key}_start"]) : '08:00'; ?>">
                                </div>
                            </td>
                            <td>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">
                                        <span class="material-icons" style="font-size:16px;">schedule</span>
                                    </span>
                                    <input type="time" step="60" class="form-control"
                                        name="campaign_<?php echo $key; ?>_end"
                                        value="<?php echo isset($fb_options["campaign_{$key}_end"]) ?
                                                    htmlspecialchars($fb_options["campaign_{$key}_end"]) : '19:00'; ?>">
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-end">
        <button type="submit" name="StoreRestrictions" class="btn btn-success d-flex align-items-center px-4">
            <span class="material-icons me-1">save</span>
            Guardar restricciones
        </button>
    </div>

</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('input[type="time"]').forEach(function(input) {
            input.addEventListener('click', function() {
                if (this.showPicker) {
                    this.showPicker();
                } else {
                    this.focus();
                }
            });
        });
    });
</script>