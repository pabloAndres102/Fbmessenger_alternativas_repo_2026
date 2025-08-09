<h1><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Campaign'); ?></h1>

<?php if (isset($updated)) : $msg = erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Updated'); ?>
    <?php include(erLhcoreClassDesign::designtpl('lhkernel/alert_success.tpl.php')); ?>
<?php endif; ?>

<?php if (isset($errors)) : ?>
    <?php include(erLhcoreClassDesign::designtpl('lhkernel/validation_error.tpl.php')); ?>
<?php endif; ?>

<form action="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/editcampaign') ?>/<?php echo $item->id ?>" method="post" ng-non-bindable>

    <?php include(erLhcoreClassDesign::designtpl('lhkernel/csfr_token.tpl.php')); ?>

    <ul class="nav nav-tabs mb-3" role="tablist">
        <li role="presentation" class="nav-item"><a href="#settings" class="nav-link<?php if ($tab == '') : ?> active<?php endif; ?>" aria-controls="settings" role="tab" data-bs-toggle="tab"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Main'); ?></a></li>
    </ul>

    <div class="tab-content">
        <div role="tabpanel" class="tab-pane <?php if ($tab == '') : ?>active<?php endif; ?>" id="settings">
            <?php include(erLhcoreClassDesign::designtpl('lhfbwhatsappmessaging/parts/form_campaign.tpl.php')); ?>
        </div>
    </div>

    <div class="btn-group" role="group" aria-label="...">
        <input type="submit" class="btn btn-sm btn-secondary" name="Save_page" id="saveButton" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('system/buttons', 'Save'); ?>" style="display: none;" />
        <input type="button" class="btn btn-sm btn-secondary" name="Cancel_page" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('system/buttons', 'Volver'); ?>" id="cancelButton" />
    </div>

</form>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var nameselect = document.querySelector('input[name="name"]');
        var departmentSelect = document.querySelector('select[name="dep_id"]');
        var privateCheckbox = document.querySelector('input[name="private"]');
        var startDateTimeInput = document.getElementById('startDateTime');
        var phoneSelect = document.getElementById('id_phone_sender_id');
        var businessAccountSelect = document.querySelector('select[name="business_account_id"]');
        var templateSelect = document.querySelector('select[name="template"]');
        var saveButton = document.getElementById('saveButton');
        var cancelButton = document.getElementById('cancelButton');
        var mlCheckboxes = document.querySelectorAll('input[name="ml[]"]');
        var form = document.querySelector('form');
        var isEditing = false;

        function containsProhibitedWords(nameValue) {
            return /copia|copy/i.test(nameValue);
        }

        function toggleFields() {
            var nameValue = nameselect ? nameselect.value : '';

            if (isEditing || containsProhibitedWords(nameValue)) {
                nameselect.removeAttribute('disabled');
                departmentSelect.removeAttribute('disabled');
                privateCheckbox.removeAttribute('disabled');
                startDateTimeInput.removeAttribute('readonly');
                phoneSelect.removeAttribute('disabled');
                businessAccountSelect.removeAttribute('disabled');
                templateSelect.removeAttribute('disabled');
                mlCheckboxes.forEach(function(checkbox) {
                    checkbox.removeAttribute('disabled');
                });
                saveButton.style.display = 'inline-block';
            } else {
                nameselect.setAttribute('disabled', 'disabled');
                departmentSelect.setAttribute('disabled', 'disabled');
                privateCheckbox.setAttribute('disabled', 'disabled');
                startDateTimeInput.setAttribute('readonly', 'readonly');
                phoneSelect.setAttribute('disabled', 'disabled');
                businessAccountSelect.setAttribute('disabled', 'disabled');
                templateSelect.setAttribute('disabled', 'disabled');
                mlCheckboxes.forEach(function(checkbox) {
                    checkbox.setAttribute('disabled', 'disabled');
                });
                saveButton.style.display = 'none';
            }
        }

        toggleFields();

        form.addEventListener('submit', function(event) {
            var nameValue = nameselect ? nameselect.value : '';
            if (containsProhibitedWords(nameValue)) {
                alert('El nombre de la campaña no puede contener "copia" o "copy". Por favor, cambie el nombre.');
                event.preventDefault();
            } else {
                isEditing = false;
            }
        });

        nameselect.addEventListener('input', function() {
            isEditing = true;
            toggleFields();
        });

        cancelButton.addEventListener('click', function() {
            window.history.back();
        });
    });
</script>

