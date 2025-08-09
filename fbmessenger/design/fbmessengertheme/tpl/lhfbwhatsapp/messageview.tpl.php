<?php
$modalHeaderClass = 'pt-1 pb-1 pl-2 pr-2';
$modalHeaderTitle = erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Message variables');
$modalSize = 'lg';
$modalBodyClass = 'p-1';
?>
<?php include(erLhcoreClassDesign::designtpl('lhkernel/modal_header.tpl.php')); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <h4>Variables:</h4>
            <pre><?php echo htmlspecialchars(json_encode(json_decode($item->message_variables), JSON_PRETTY_PRINT)); ?></pre>
        </div>
        <div class="col-md-6">
            <h4>Mensaje:</h4>
            <p><?php echo nl2br(htmlspecialchars($item->message)); ?></p>
        </div>
    </div>
</div>

<?php include(erLhcoreClassDesign::designtpl('lhkernel/modal_footer.tpl.php')); ?>
