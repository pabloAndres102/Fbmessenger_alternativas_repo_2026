<!-- Incluye la hoja de estilos de Flatpickr -->
<style>
    .checkbox-label {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 10px;
        cursor: pointer;
        font-size: 16px;
    }

    .checkbox-label input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 25px;
        width: 25px;
        background-color: #eee;
        border-radius: 5px;
    }

    .checkbox-label:hover input~.checkmark {
        background-color: #ccc;
    }

    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    .checkbox-label input:checked~.checkmark:after {
        display: block;
    }

    .checkbox-label .checkmark:after {
        left: 9px;
        top: 5px;
        width: 5px;
        height: 10px;
        border: solid #333;
        border-width: 0 3px 3px 0;
        transform: rotate(45deg);
    }
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<!-- Incluye la librería de Flatpickr -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<div class="row">
    <div class="col-6">
        <div class="row">
            <div class="col-9">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <small><strong>Tenga en cuenta:</strong> Los contactos desactivados serán ignorados en el envío de la campaña, Si desea activar o desactivar un contacto haga click <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/mailingrecipient') ?>"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('system/buttons', 'Aqui'); ?></a></small>
                </div>
                <div class="form-group">
                    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Name'); ?>*</label>
                    <input type="text" maxlength="250" class="form-control form-control-sm" name="name" value="<?php echo htmlspecialchars($item->name) ?>" />
                </div>
            </div>
            <div class="col-9">
                <div class="form-group">
                    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Department'); ?></label>
                    <?php echo erLhcoreClassRenderHelper::renderCombobox(array(
                        'input_name'     => 'dep_id',
                        'optional_field' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Select department'),
                        'selected_id'    => $item->dep_id,
                        'css_class'      => 'form-control form-control-sm',
                        'list_function'  => 'erLhcoreClassModelDepartament::getList',
                        'list_function_params'  => array('limit' => false, 'sort' => 'name ASC'),
                    )); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-9">
                <label><input type="checkbox" name="private" value="on" <?php $item->private == \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaign::LIST_PRIVATE ? print ' checked="checked" ' : '' ?>> <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Private'); ?></label>
            </div>
        </div>
        <div class="row">
            <div class="col-9" style="margin-top: 10px;">
                <div class="form-group">
                    <label class="<?php ($item->starts_at > 0 && $item->starts_at < time()) ? print 'text-danger' : '' ?> "><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Start sending at'); ?> <b><?php print date_default_timezone_get() ?></b>, Current time - <b>[<?php echo (new DateTime('now', new DateTimeZone(date_default_timezone_get())))->format('Y-m-d H:i:s') ?>]</b></label>
                    <input id="startDateTime" class="form-control form-control-sm" name="starts_at" type="text" value="<?php echo date('Y-m-d\TH:i', $item->starts_at > 0 ? $item->starts_at : time()) ?>">

                </div>
                <?php if ($item->status == \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaign::STATUS_PENDING) : ?>
                    <div class="badge bg-warning"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Pending, campaign has not started yet.'); ?></div>
                <?php elseif ($item->status == \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaign::STATUS_IN_PROGRESS) : ?>
                    <div class="badge bg-info"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'In progress'); ?></div>

                    <input type="submit" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Pause a running campaign'); ?>" class="btn btn-xs btn-warning" name="PauseCampaign" />

                <?php elseif ($item->status == \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaign::STATUS_FINISHED) : ?>
                    <label><input type="checkbox" name="activate_again" value="on"> <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Set campaign status to pending. E.g You can activate it again if you have added more recipients.'); ?></label>
                <?php endif; ?>
            </div>

            <div class="form-check form-switch">
                <!-- <input class="form-check-input" type="checkbox" <?php if ($item->id == null || \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_PENDING, 'campaign_id' => $item->id]]) == 0) : $disabledCampaign = true; ?>disabled<?php endif; ?> name="enabled" id="enabled" <?php $item->enabled == 1 ? print ' checked ' : '' ?>> -->
                <!-- <label class="form-check-label" for="enabled">
                    <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Activate campaign'); ?>
                </label> -->
            </div>

            <div class="form-group">
            <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Seleccionar lista de contactos'); ?></label>
            <br><br>
            <div class="contact-list-checkboxes" style="max-height: 200px; overflow-y: auto;">
                <?php
                $contactLists = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppContactList::getList();
                
                // Decodificar lists_id si existe
                $selectedLists = !empty($item->lists_id) ? json_decode($item->lists_id, true) : [];
    
                foreach ($contactLists as $contactList) {
                    // Verificar si el ID de la lista está en el array de listas seleccionadas
                    $isChecked = in_array($contactList->id, $selectedLists) ? 'checked' : '';
                    echo '<label class="checkbox-label">';
                    echo '<input type="checkbox" name="ml[]" value="' . $contactList->id . '" ' . $isChecked . '>';
                    echo '<span class="checkmark"></span>';
                    echo htmlspecialchars($contactList->name);
                    echo '</label>';
                }
                ?>
            </div>
        </div>


        </div>
        <script>
            var messageFieldsValues = <?php echo json_encode($item->message_variables_array); ?>;
            var businessAccountId = <?php echo (int)$item->business_account_id ?>;
        </script>

        <div class="form-group" style="margin-top: 10px;">
            <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Sender Phone'); ?></label>
            <select name="phone_sender_id" id="id_phone_sender_id" class="form-control form-control-sm" title="display_phone_number | verified_name | code_verification_status | quality_rating">
                <?php foreach ($phones as $phone) : ?>
                    <option value="<?php echo $phone['id'] ?>">
                        <?php echo $phone['display_phone_number'], ' | ', $phone['verified_name'], ' | ', $phone['code_verification_status'], ' | ', $phone['quality_rating'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="row">
            <div class="col-9">
                <div class="form-group">
                    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Business account'); ?>, <small><i><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'you can set a custom business account'); ?></i></small></label>
                    <?php echo erLhcoreClassRenderHelper::renderCombobox(array(
                        'input_name'     => 'business_account_id',
                        'optional_field' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Default configuration'),
                        'selected_id'    => $item->business_account_id,
                        'css_class'      => 'form-control form-control-sm',
                        'list_function'  => '\LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppAccount::getList'
                    )); ?>
                </div>
            </div>
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
                        // Agrega aquí los nombres de las plantillas que deseas excluir
                    );

                    // Verifica si el nombre de la plantilla está en la lista de excluidas
                    if (in_array($template['name'], $excludedTemplates)) {
                        continue; // Si está en la lista, salta esta iteración y no agrega la plantilla al select
                    }

                    // Verifica si la plantilla tiene estado "approved" antes de agregarla al select
                    if ($template['status'] === 'APPROVED') {
                    ?>
                        <option <?php if ($_GET['template'] == $template['name']) : ?>selected="selected" <?php endif; ?> value="<?php echo htmlspecialchars($template['name'] . '||' . $template['language'] . '||' . $template['id']) ?>"><?php echo htmlspecialchars($template['name'] . ' [' . $template['language'] . ']') ?></option>
                    <?php
                    }
                    ?>
                <?php endforeach; ?>
            </select>
        </div>

        <div id="arguments-template-form"></div>

    </div>
    <div class="col-4">
        <div id="arguments-template"></div>
    </div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializa Flatpickr en el input de fecha y hora
        flatpickr('#startDateTime', {
            enableTime: true, // Permite la selección de la hora
            dateFormat: 'Y-m-d H:i', // Formato de fecha y hora
            time_24hr: true, // Utiliza el formato de 24 horas
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Obtiene una referencia al formulario
        var form = document.querySelector('form'); // Reemplaza 'form' con el selector correcto para tu formulario

        // Nombres de campos a excluir de la validación
        var excludeFields = ['email'];

        // Agrega un evento de escucha para el evento "submit" del formulario
        form.addEventListener('submit', function(event) {
            // Verifica si el formulario está en la pestaña de estadísticas
            var isStatisticsTab = document.querySelector('a[href="#statistic"]').classList.contains('active');

            // Si está en la pestaña de estadísticas, permite el envío del formulario
            if (isStatisticsTab) {
                return;
            }

            // Obtiene una lista de todos los elementos de entrada que deseas validar
            var inputsToValidate = form.querySelectorAll('.form-control');

            // Variable para rastrear si se encontró un campo vacío excluido
            var foundEmptyExcludedField = false;

            // Recorre la lista de elementos de entrada
            for (var i = 0; i < inputsToValidate.length; i++) {
                var input = inputsToValidate[i];

                // Verifica si el campo está vacío
                if (input.value.trim() === '') {
                    // Verifica si el nombre del campo está en el array de campos excluidos
                    if (excludeFields.some(function(excludedName) {
                            return input.name.indexOf(excludedName) === 0;
                        })) {
                        // Si es un campo excluido, marca que se encontró un campo vacío excluido
                        foundEmptyExcludedField = true;
                    } else {
                        // Si no es un campo excluido, evita que el formulario se envíe
                        event.preventDefault();
                        // Muestra un mensaje de error o realiza cualquier otra acción que desees
                        alert('Por favor, complete todos los campos obligatorios.');
                        // Sale del bucle una vez que se encuentra un campo vacío
                        return;
                    }
                }
            }

            // Si se encontró un campo vacío excluido y no se encontraron otros campos vacíos, permite enviar el formulario
            if (foundEmptyExcludedField) {
                return;
            }
        });
    });
</script>