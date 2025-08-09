<?php
$modalHeaderClass = 'pt-1 pb-1 pl-2 pr-2';
$modalHeaderTitle = erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Message Details');
$modalSize = 'lg';
$modalBodyClass = 'p-1';
?>
<?php include(erLhcoreClassDesign::designtpl('lhkernel/modal_header.tpl.php')); ?>

<p>Message: <?php echo htmlspecialchars($item->message); ?></p>
<p>Message Variables: <?php echo htmlspecialchars($item->message_variables); ?></p>

<?php include(erLhcoreClassDesign::designtpl('lhkernel/modal_footer.tpl.php')); ?>
