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

        var restricciones = <?php echo json_encode([
                                'monday'    => ['start' => $restricciones['campaign_monday_start'] ?? '', 'end' => $restricciones['campaign_monday_end'] ?? ''],
                                'tuesday'   => ['start' => $restricciones['campaign_tuesday_start'] ?? '', 'end' => $restricciones['campaign_tuesday_end'] ?? ''],
                                'wednesday' => ['start' => $restricciones['campaign_wednesday_start'] ?? '', 'end' => $restricciones['campaign_wednesday_end'] ?? ''],
                                'thursday'  => ['start' => $restricciones['campaign_thursday_start'] ?? '', 'end' => $restricciones['campaign_thursday_end'] ?? ''],
                                'friday'    => ['start' => $restricciones['campaign_friday_start'] ?? '', 'end' => $restricciones['campaign_friday_end'] ?? ''],
                                'saturday'  => ['start' => $restricciones['campaign_saturday_start'] ?? '', 'end' => $restricciones['campaign_saturday_end'] ?? ''],
                                'sunday'    => ['start' => $restricciones['campaign_sunday_start'] ?? '', 'end' => $restricciones['campaign_sunday_end'] ?? ''],
                            ]); ?>;

        var form = document.querySelector('form');

        form.addEventListener('submit', function(event) {

            var startsAtInput = document.getElementById('startDateTime');
            var startsAtValue = startsAtInput.value;

            if (!startsAtValue) {
                alert('Debes seleccionar una fecha y hora de inicio.');
                event.preventDefault();
                return;
            }

            var startsAtDate = new Date(startsAtValue);
            var currentTime = new Date();

            if (startsAtDate < currentTime) {
                alert('La fecha de inicio no puede estar en el pasado.');
                event.preventDefault();
                return;
            }

            var days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
            var dayName = days[startsAtDate.getDay()];
            var horaMin = restricciones[dayName].start;
            var horaMax = restricciones[dayName].end;

            if (!horaMin || !horaMax) {
                alert('No hay restricción configurada para el día seleccionado: ' + dayName);
                event.preventDefault();
                return;
            }

            var startLimit = new Date(startsAtDate.toDateString() + ' ' + horaMin);
            var endLimit = new Date(startsAtDate.toDateString() + ' ' + horaMax);

            if (startsAtDate < startLimit || startsAtDate > endLimit) {
                alert(`La fecha de inicio debe estar entre ${horaMin} y ${horaMax} para el día ${dayName}.`);
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
        var url = '<?php echo erLhcoreClassDesign::baseurl('fbwhatsapp/template_table') ?>/' + selectedTemplateName + '/' + texto + '/' + texto2 + '/' + texto3 + '/' + texto4 + '/' + texto5 + '?header=' + texto_header;


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