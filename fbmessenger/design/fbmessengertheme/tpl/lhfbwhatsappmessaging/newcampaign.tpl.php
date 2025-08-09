<?php if (isset($errors)) : ?>
    <?php include(erLhcoreClassDesign::designtpl('lhkernel/validation_error.tpl.php')); ?>
<?php endif; ?>

<form enctype="multipart/form-data" action="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/newcampaign') ?>" id="form" method="post" ng-non-bindable>

    <?php include(erLhcoreClassDesign::designtpl('lhkernel/csfr_token.tpl.php')); ?>

    <?php include(erLhcoreClassDesign::designtpl('lhfbwhatsappmessaging/parts/form_campaign.tpl.php')); ?>
    <div class="btn-group" role="group" aria-label="...">
        <input type="submit" class="btn btn-sm btn-secondary" name="Save_continue" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Send campaign'); ?>" />
        <input type="submit" class="btn btn-sm btn-secondary" name="Cancel_page" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('system/buttons', 'Cancel'); ?>" />
    </div> &nbsp;&nbsp;
    <button type="button" class="btn btn-warning btn-sm" onclick="return previewTemplate()">
                <i class="material-icons">visibility</i> Previsualizar
    </button>

</form>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Obtiene una referencia al formulario
    var form = document.querySelector('form');

    // Agrega un evento de escucha para el evento "submit" del formulario
    form.addEventListener('submit', function(event) {
        // Obtiene el valor del campo starts_at
        var startsAtInput = document.getElementById('startDateTime');
        var startsAtValue = startsAtInput.value;

        // Convierte el valor a una fecha JavaScript
        var startsAtDate = new Date(startsAtValue);

        // Obtiene el día de la semana y la hora del día
        var dayOfWeek = startsAtDate.getDay(); // 0 para Domingo, 1 para Lunes, ..., 6 para Sábado
        var hourOfDay = startsAtDate.getHours();

        // Obtiene la hora actual
        var currentTime = new Date();

        // Verifica las condiciones de validez
        if (
            (dayOfWeek >= 1 && dayOfWeek <= 5 && hourOfDay >= 7 && hourOfDay < 19) ||
            (dayOfWeek == 6 && hourOfDay >= 8 && hourOfDay < 15)
        ) {
            // Verifica si la fecha no está en el pasado
            if (startsAtDate >= currentTime) {
                // Permite el envío del formulario
                return;
            } else {
                // Muestra un mensaje de error si la fecha está en el pasado
                alert('La fecha de inicio no puede estar en el pasado.');
                // Evita que el formulario se envíe
                event.preventDefault();
            }
        } else {
            // Muestra un mensaje de error si la fecha y hora no son válidas
            alert('La fecha de inicio debe ser de Lunes a Viernes de 7:00 a 19:00 y Sábado de 8:00 a 15:00.');
            // Evita que el formulario se envíe
            event.preventDefault();
        }
    });
});

</script>
<script>
    function previewTemplate() {
        var selectedTemplate = document.getElementById("template-to-send").value;
        var texto = document.getElementById("field_1") ? document.getElementById("field_1").value : '';
        var texto2 = document.getElementById("field_2") ? document.getElementById("field_2").value : '';
        var texto3 = document.getElementById("field_3") ? document.getElementById("field_3").value : '';
        var texto4 = document.getElementById("field_4") ? document.getElementById("field_4").value : '';
        var texto5 = document.getElementById("field_5") ? document.getElementById("field_5").value : '';
        var texto_header = document.getElementById("field_header_1") ? document.getElementById("field_header_1").value : '';
        var parts = selectedTemplate.split("||");
        var selectedTemplateName = parts[0];
        var url = '<?php echo erLhcoreClassDesign::baseurl('fbwhatsapp/template_table') ?>/' + selectedTemplateName + '/' + texto + '/' + texto2 + '/' + texto3 + '/' + texto4 + '/' + texto5 + '?header='+texto_header;


        if (selectedTemplateName !== "") {
            return lhc.revealModal({
                'title': 'Import',
                'height': 350,
                'backdrop': true,
                'url': url
            });
        } else {
            alert("Por favor, selecciona una plantilla antes de previsualizar.");
        }
    }
</script>
