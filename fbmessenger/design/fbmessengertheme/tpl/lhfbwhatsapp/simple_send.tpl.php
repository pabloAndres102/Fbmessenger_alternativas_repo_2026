<!-- Incluye la hoja de estilos de Flatpickr -->
<?php $modalHeaderClass = 'pt-1 pb-1 pl-2 pr-2';
$modalSize = 'xl';
$modalBodyClass = 'p-1';
$appendPrintExportURL = ''; ?>
<?php include(erLhcoreClassDesign::designtpl('lhkernel/modal_header.tpl.php'));?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<!-- Incluye la librería de Flatpickr -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<h1><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Send a single message'); ?></h1>

<?php if (isset($errors)) : ?>
    <?php include(erLhcoreClassDesign::designtpl('lhkernel/validation_error.tpl.php')); ?>
<?php endif; ?>
<?php if (isset($updated)) : ?>
    <?php
    $msg = erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Actualizado con éxito. Para saber el estado de su mensaje consulte ');
    $linkText = erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Aquí');
    $linkUrl = erLhcoreClassDesign::baseurl('fbwhatsapp/messages');
    ?>
    <div class="alert alert-success" role="alert">
        <p><?php echo $msg; ?><a href="<?php echo $linkUrl; ?>" target="_blank"><?php echo $linkText; ?></a></p>
    </div>
<?php endif; ?>




<?php if (isset($fbcommand)) : ?>
    <div class="alert alert-info">
        <p><strong>Nombre de plantilla: </strong> <?php echo htmlspecialchars($fbcommand['template_name']) ?></p>
        <p><strong>Idioma de plantilla: </strong> <?php echo htmlspecialchars($fbcommand['template_lang']) ?></p>
        <?php if (isset($fbcommand['args']) && !empty($fbcommand['args'])) : ?>
            <h5>Campos: </h5>
            <ul>
                <?php foreach ($fbcommand['args'] as $key => $value) : ?>
                    <li><strong><?php echo htmlspecialchars($key) ?>: </strong> <?php echo htmlspecialchars($value) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php if (isset($whatsapp_contact)) : ?>

    <div class="row">
        <div class="col-6">
            <ul class="fs14">
                <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Name'); ?> - <?php echo htmlspecialchars($whatsapp_contact->name) ?></li>
                <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Lastname'); ?> - <?php echo htmlspecialchars($whatsapp_contact->lastname) ?></li>
                <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'E-mail'); ?> - <?php echo htmlspecialchars($whatsapp_contact->email) ?></li>
                <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Title'); ?> - <?php echo htmlspecialchars($whatsapp_contact->title) ?></li>
                <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Company'); ?> - <?php echo htmlspecialchars($whatsapp_contact->company) ?></li>
                <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Date'); ?> - <?php echo htmlspecialchars($whatsapp_contact->date_front) ?></li>
                <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Attribute string 6'); ?> - <?php echo htmlspecialchars($whatsapp_contact->attr_str_6) ?></li>
                <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'File 1'); ?> - <?php echo htmlspecialchars($whatsapp_contact->file_1) ?></li>
                <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'File 2'); ?> - <?php echo htmlspecialchars($whatsapp_contact->file_2) ?></li>
            </ul>
        </div>
        <div class="col-6">
            <ul class="fs14">
                <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Attribute string 1'); ?> - <?php echo htmlspecialchars($whatsapp_contact->attr_str_1) ?></li>
                <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Attribute string 2'); ?> - <?php echo htmlspecialchars($whatsapp_contact->attr_str_2) ?></li>
                <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Attribute string 3'); ?> - <?php echo htmlspecialchars($whatsapp_contact->attr_str_3) ?></li>
                <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Attribute string 4'); ?> - <?php echo htmlspecialchars($whatsapp_contact->attr_str_4) ?></li>
                <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Attribute string 5'); ?> - <?php echo htmlspecialchars($whatsapp_contact->attr_str_5) ?></li>
                <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'File 3'); ?> - <?php echo htmlspecialchars($whatsapp_contact->file_3) ?></li>
                <li><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'File 4'); ?> - <?php echo htmlspecialchars($whatsapp_contact->file_4) ?></li>
            </ul>
        </div>
    </div>
<?php endif; ?>

<form id="whatsapp-form" enctype="multipart/form-data" action="<?php echo erLhcoreClassDesign::baseurl('fbwhatsapp/simple_send') ?><?php if (isset($whatsapp_contact)) : ?>/(recipient)/<?php echo $whatsapp_contact->id;
                                                                                                                                                                                endif; ?>" method="post" ng-non-bindable target="_blank" onsubmit="return lhinst.submitModalForm($(this))">
    <div class="modal-body">
        <?php include(erLhcoreClassDesign::designtpl('lhkernel/csfr_token.tpl.php')); ?>
        <div class="row">
            <div class="col-8">

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Recipient Phone'); ?>*</label>
                            <div class="input-group input-group-sm mb-3">
                                <span class="input-group-text" id="basic-addon1">+</span>
                                <input <?php if (isset($whatsapp_contact)) : ?>disabled="disabled" <?php endif; ?> type="text" name="phone" placeholder="37065111111" class="form-control" value="<?php echo htmlspecialchars((isset($phone_chat) ? $phone_chat : $send->phone)) ?>" aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Department'); ?>*</label>
                    <?php echo erLhcoreClassRenderHelper::renderCombobox(array(
                        'input_name'     => 'dep_id',
                        'optional_field' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Select department'),
                        'selected_id'    => $send->dep_id,
                        'css_class'      => 'form-control form-control-sm',
                        'list_function'  => 'erLhcoreClassModelDepartament::getList',
                        'list_function_params'  => array('limit' => false, 'sort' => 'name ASC'),
                    )); ?>
                </div>

                <div class="form-group">
                    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Business account'); ?>, <small><i><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'you can set a custom business account'); ?></i></small></label>
                    <?php echo erLhcoreClassRenderHelper::renderCombobox(array(
                        'input_name'     => 'business_account_id',
                        'optional_field' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Default configuration'),
                        'selected_id'    => $send->business_account_id,
                        'css_class'      => 'form-control form-control-sm',
                        'list_function'  => '\LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppAccount::getList'
                    )); ?>
                </div>

                <div class="form-group">
                    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Sender Phone'); ?></label>
                    <select name="phone_sender_id" id="id_phone_sender_id" class="form-control form-control-sm" title="display_phone_number | verified_name | code_verification_status | quality_rating">
                        <?php foreach ($phones as $phone) : ?>
                            <option value="<?php echo $phone['id'] ?>">
                                <?php echo $phone['display_phone_number'], ' | ', $phone['verified_name'], ' | ', $phone['code_verification_status'], ' | ', $phone['quality_rating'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Template'); ?>*</label>
                    <select name="template" class="form-control form-control-sm" id="template-to-send">
                        <option value=""><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Choose a template'); ?></option>
                        <?php foreach ($templates as $template) : ?>
                            <?php
                            // Nombres de plantillas a excluir
                            $excludedTemplates = array(
                                'sample_purchase_feedback',
                                'sample_issue_resolution',
                                'sample_flight_confirmation',
                                'sample_shipping_confirmation',
                                'sample_happy_hour_announcement',
                                'sample_movie_ticket_confirmation'
                            );

                            // Verifica si el nombre de la plantilla está en la lista de excluidas
                            if (in_array($template['name'], $excludedTemplates)) {
                                continue; // Si está en la lista, salta esta iteración y no agrega la plantilla al select
                            }

                            // Verifica si la plantilla tiene estado "approved" antes de agregarla al select
                            if ($template['status'] === 'APPROVED') {
                            ?>
                                <option <?php if ($send->template == $template['name']) : ?>selected="selected" <?php endif; ?> value="<?php echo htmlspecialchars($template['name'] . '||' . $template['language'] . '||' . $template['id']) ?>"><?php echo htmlspecialchars($template['name'] . ' [' . $template['language'] . ']') ?></option>
                            <?php
                            }
                            ?>
                        <?php endforeach; ?>
                    </select>
                </div>

                <br>

                <script>
                    var messageFieldsValues = <?php echo json_encode($send->message_variables_array); ?>;
                    <?php if (isset($business_account_id) && is_numeric($business_account_id)) : ?>
                        var businessAccountId = <?php echo (int)$business_account_id ?>;
                    <?php endif; ?>
                </script>

                <div id="arguments-template-form"></div>

                <div class="form-group">
                    <label><input onchange="$('#schedule_ts').toggle()" <?php if ($send->status == \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_SCHEDULED) : ?>checked="checked" <?php endif; ?> type="checkbox" name="schedule_message" id="schedule_message" /> <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Schedule a message'); ?>, <small class="text-muted"><?php echo date('Y-m-d H:i', time()) ?></small></label>
                </div>

                <div id="schedule_ts" class="pb-2" style="display:<?php if ($send->status == \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_SCHEDULED) : ?>block<?php else : ?>none<?php endif; ?>">
                    <div class="pb-2">
                        <input type="datetime-local" class="form-control form-control-sm" name="scheduled_at" id="scheduled_at" value="<?php echo date('Y-m-d\TH:i', $send->scheduled_at > 0 ? $send->scheduled_at : time()) ?>" required />
                    </div>

                    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Campaign name'); ?></label>
                    <input type="text" class="form-control form-control-sm" maxlength="50" name="campaign_name" id="campaign_name" placeholder="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Single campaign'); ?>" value="<?php echo htmlspecialchars((string)$send->campaign_name) ?>" />
                </div>

            </div>
            <div class="col-4">
                <div id="arguments-template"></div>
            </div>
        </div>

    </div>
    <button class="btn btn-secondary btn-sm" type="submit" value=""><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Send a test message'); ?></button>&nbsp;&nbsp;
    <button type="button" class="btn btn-warning btn-sm" onclick="return previewTemplate()">
        <i class="material-icons">visibility</i> Previsualizar
    </button>
</form>

<?php include(erLhcoreClassDesign::designtpl('lhkernel/modal_footer.tpl.php'));?>

<script>
    (function() {
    $('#template-to-send').change(function() {
        $.postJSON(WWW_DIR_JAVASCRIPT + '/fbwhatsapp/rendersend2/' + $(this).val() + (typeof businessAccountId !== 'undefined' ? '/' + businessAccountId : ''), {'data': JSON.stringify(messageFieldsValues)}, function(data) {
            $('#arguments-template').html(data.preview);
            $('#arguments-template-form').html(data.form);
        });
    });
    if ($('#template-to-send').val() != '') {
        $.postJSON(WWW_DIR_JAVASCRIPT + '/fbwhatsapp/rendersend2/' + $('#template-to-send').val() + (typeof businessAccountId !== 'undefined' ? '/' + businessAccountId : ''), {'data': JSON.stringify(messageFieldsValues)}, function(data) {
            $('#arguments-template').html(data.preview);
            $('#arguments-template-form').html(data.form);
        });
    }
    $('#id_business_account_id').change(function(){
        businessAccountId = $(this).val();
        $('#arguments-template').html('');
        $('#arguments-template-form').html('');
        $('#template-to-send').html('<option>Loading...</option>');
        $('#id_phone_sender_id').html('<option>Loading...</option>');
        $.postJSON(WWW_DIR_JAVASCRIPT + '/fbwhatsapp/rendertemplates/' +businessAccountId, function(data) {
            $('#template-to-send').html(data.templates);
            $('#id_phone_sender_id').html(data.phones);
        });
    });
})();
</script>
<script>
    function previewTemplate() {
        var selectedTemplate = document.getElementById("template-to-send").value;
        var texto = document.getElementById("field_1") ? document.getElementById("field_1").value : '';
        var texto2 = document.getElementById("field_2") ? document.getElementById("field_2").value : '';
        var texto3 = document.getElementById("field_3") ? document.getElementById("field_3").value : '';
        var texto4 = document.getElementById("field_4") ? document.getElementById("field_4").value : '';
        var texto5 = document.getElementById("field_5") ? document.getElementById("field_5").value : '';

        var header_img = document.getElementById("field_header_img_1") ? document.getElementById("field_header_img_1").value : '';
        var header_video = document.getElementById("field_header_video_1") ? document.getElementById("field_header_video_1").value : '';

        var texto_header = document.getElementById("field_header_1") ? document.getElementById("field_header_1").value : '';
        var parts = selectedTemplate.split("||");
        var selectedTemplateName = parts[0];
        var url = '<?php echo erLhcoreClassDesign::baseurl('fbwhatsapp/template_table') ?>/' + selectedTemplateName + '/' + texto + '/' + texto2 + '/' + texto3 + '/' + texto4 + '/' + texto5 + '?header=' + texto_header + '&img=' + header_img + '&video=' + header_video;
        console.log(url);

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




<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Selecciona el elemento de entrada de fecha y hora
        var scheduledAtInput = document.getElementById('scheduled_at');
        var scheduleCheckbox = document.getElementById('schedule_message');

        // Función para validar la fecha y hora seleccionadas
        function validateScheduledDateTime() {
            // Obtiene la fecha y hora actual en formato ISO8601
            var currentDateTime = new Date();
            currentDateTime.setMinutes(currentDateTime.getMinutes() + 5); // Agrega 5 minutos

            // Obtiene la fecha y hora seleccionada
            var selectedDateTime = new Date(scheduledAtInput.value);

            // Verifica si la fecha seleccionada es anterior a la actual más 5 minutos
            if (selectedDateTime < currentDateTime) {
                // Calcula la fecha y hora mínima permitida (actual más 5 minutos)
                currentDateTime.setMinutes(currentDateTime.getMinutes() - 5);


                scheduledAtInput.value = currentDateTime.toISOString().slice(0, 16);
            }
        }

        // Agrega un evento de escucha al cambio en el valor del input
        scheduledAtInput.addEventListener('change', validateScheduledDateTime);

        // Agrega un evento de escucha al cambio en el estado del checkbox "Schedule a message"
        scheduleCheckbox.addEventListener('change', function() {
            // Si el checkbox se desmarca, restablece la fecha y hora mínima permitida
            if (!scheduleCheckbox.checked) {
                var currentDateTime = new Date();
                currentDateTime.setMinutes(currentDateTime.getMinutes() + 5); // Agrega 5 minutos
                scheduledAtInput.value = currentDateTime.toISOString().slice(0, 16);
            }
        });

        // Ejecuta la validación inicial al cargar la página
        validateScheduledDateTime();
    });
</script>

<script>
    var excludeFields = [];

    function toggleScheduleFields() {
        var scheduleCheckbox = document.getElementById("schedule_message");
        var scheduledAtInput = document.getElementById("scheduled_at");
        var campaignNameInput = document.getElementById("campaign_name");
        var whatsappForm = document.getElementById("whatsapp-form");

        var templateSelect = document.getElementById("template-to-send");
        var argumentsTemplateForm = document.getElementById("arguments-template-form");

        if (scheduleCheckbox.checked) {
            scheduledAtInput.required = true;
            if (campaignNameInput.value.trim() === "") {
                campaignNameInput.required = true;
            } else {
                campaignNameInput.required = false;
            }
        } else {
            scheduledAtInput.required = false;
            campaignNameInput.required = false;
        }

        if (templateSelect.value !== "") {

            var variableFields = argumentsTemplateForm.querySelectorAll('input[type="text"]');
            var variablesComplete = true;
            variableFields.forEach(function(field) {
                var fieldName = field.name;

                var excludeField = excludeFields.some(function(excludeField) {
                    return fieldName.includes(excludeField);
                });

                if (!excludeField && field.value.trim() === "") {
                    variablesComplete = false;
                    field.required = true;
                } else {
                    field.required = false;
                }
            });

            // Si no se han completado todas las variables, mostrar una alerta y evitar que el formulario se envíe
            if (!variablesComplete) {
                alert("Por favor, complete todos los campos de la plantilla.");
                event.preventDefault();
                return;
            }
        } else {
            // Si no se ha seleccionado una plantilla, hacer que los campos de variables no sean obligatorios
            var variableFields = argumentsTemplateForm.querySelectorAll('input[type="text"]');
            variableFields.forEach(function(field) {
                field.required = false;
            });
        }
    }

    // Llama a la función al cargar la página para establecer el estado inicial
    window.onload = toggleScheduleFields;

    // Llama a la función cuando cambia la selección de plantilla
    document.getElementById("template-to-send").addEventListener("change", toggleScheduleFields);

    // Llama a la función cuando cambia el estado del checkbox "Schedule a message"
    document.getElementById("schedule_message").addEventListener("change", toggleScheduleFields);

    // Agrega una función de validación previa al envío del formulario
    document.getElementById("whatsapp-form").addEventListener("submit", function(event) {
        toggleScheduleFields(); // Ejecuta la validación antes de enviar
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializa Flatpickr en el input de fecha y hora
        flatpickr('#scheduled_at', {
            enableTime: true, // Permite la selección de la hora
            dateFormat: 'Y-m-d H:i', // Formato de fecha y hora
            time_24hr: true, // Utiliza el formato de 24 horas
        });
    });
</script>