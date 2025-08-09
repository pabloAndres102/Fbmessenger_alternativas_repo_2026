<?php
$modalHeaderClass = 'pt-1 pb-1 pl-2 pr-2';
$modalHeaderTitle = erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger','Message preview');
$modalSize = 'lg';
$modalBodyClass = 'p-1';

$errorMessage = isset($errorMessage) && !empty($errorMessage) ? htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8') : 'Error desconocido';
$errorData = isset($errorData) && !empty($errorData) ? htmlspecialchars($errorData, ENT_QUOTES, 'UTF-8') : 'Error desconocido';

include(erLhcoreClassDesign::designtpl('lhkernel/modal_header.tpl.php'));
?>

<div class="modal-body">
    <div class="alert alert-danger" role="alert">
        <h4>Error Message</h4>
        <p><?= $errorMessage ?></p>
    </div>
    <div class="alert alert-danger" role="alert">
        <h4>Error Data</h4>
        <pre><?= $errorData ?></pre>
    </div>
</div>

<?php include(erLhcoreClassDesign::designtpl('lhkernel/modal_footer.tpl.php'));?>
