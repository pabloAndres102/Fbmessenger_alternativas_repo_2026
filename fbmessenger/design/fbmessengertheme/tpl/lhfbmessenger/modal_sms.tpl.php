<?php
$modalHeaderClass = 'pt-1 pb-1 pl-2 pr-2';
$modalHeaderTitle = 'Enviar SMS Individual';
$modalSize = 'md';
$modalBodyClass = 'p-2';
?>
<?php include(erLhcoreClassDesign::designtpl('lhkernel/modal_header.tpl.php')); ?>

<div id="alert-container"></div>

<form id="sms-form" autocomplete="off">
    <div class="form-group mb-2">
        <label><i class="material-icons">call</i> Teléfono (+57300...)</label>
        <input type="text" name="phone" id="phone" class="form-control form-control-sm" placeholder="573194479242">
    </div>

    <div class="form-group mb-3">
        <label><i class="material-icons">chat</i> Mensaje</label>
        <textarea name="message" id="message" class="form-control form-control-sm" rows="3"></textarea>
    </div>

    <div class="modal-footer p-1">
        <button type="submit" class="btn btn-sm btn-primary" id="btn-send">
            <i class="material-icons">send</i> Enviar SMS
        </button>
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cerrar</button>
    </div>
</form>

<script>
$(document).ready(function() {
    $('#sms-form').on('submit', function(e) {
        e.preventDefault(); // Evita redirección

        var phone = $('#phone').val().trim();
        var message = $('#message').val().trim();
        var btn = $('#btn-send');

        if (phone === '' || message === '') {
            showAlert('warning', 'Debes llenar todos los campos.');
            return;
        }

        btn.prop('disabled', true).text('Enviando...');

        $.ajax({
            url: '<?php echo erLhcoreClassDesign::baseurl('fbmessenger/modal_sms'); ?>',
            type: 'POST',
            dataType: 'json',
            data: { phone: phone, message: message },
            success: function(response) {
                if (response.status === 'success') {
                    showAlert('success', response.message + '<br>MessageId: ' + response.data.MessageId + '<br>Teléfono: ' + response.data.Telefono);
                } else {
                    showAlert('danger', response.message);
                }
            },
            error: function(xhr, status, error) {
                showAlert('danger', 'Error al enviar la solicitud AJAX: ' + error);
            },
            complete: function() {
                btn.prop('disabled', false).text('Enviar SMS');
            }
        });
    });

    function showAlert(type, message) {
        $('#alert-container').html(
            '<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
            message + '</div>'
        );
    }
});
</script>

<?php include(erLhcoreClassDesign::designtpl('lhkernel/modal_footer.tpl.php')); ?>
