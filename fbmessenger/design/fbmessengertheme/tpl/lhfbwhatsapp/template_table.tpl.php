<?php
$modalHeaderClass = 'pt-1 pb-1 pl-2 pr-2';
$modalHeaderTitle = erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Preview');
$modalSize = 'lg';
$modalBodyClass = 'p-1';
?>
  <style>

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        h4 {
            font-size: 24px;
            color: inherit; /* Cambiado a color por defecto */
            margin-bottom: 10px;
        }

        h6 {
            font-size: 18px;
            color: #555;
            margin-bottom: 10px;
        }

        .rounded {
            border-radius: 5px;
        }

        .bg-light {
            background-color: #f8f9fa;
        }

        .p-2 {
            padding: 10px;
        }
    </style>
<?php include(erLhcoreClassDesign::designtpl('lhkernel/modal_header.tpl.php')); ?>


<div class="container">
        <h2><span><?php echo $templateName ?></span></h2>
        <h4><span><?php echo $prueba ?></span></h4>
        <?php if (isset($mediaIMG)): ?>
            <img src="<?php echo htmlspecialchars($mediaIMG) ?>" width="100px" />
        <?php endif; ?>
        <?php if(isset($mediaVIDEO)): ?>
            <video width="100">
                    <source src="<?php echo htmlspecialchars($mediaVIDEO) ?>" type="video/mp4">
            </video>
        <?php endif ?>
        <div class="rounded bg-light p-2">
            <h6><span><?php echo $bodyText ?></span></h6>
        </div>
        <br>
        <?php if (isset($buttons)) : ?>
            <?php foreach ($buttons as $button) : ?>
                <div class="pb-2"><button class="btn btn-sm btn-secondary"><?php echo htmlspecialchars($button['text']) ?> | <?php echo htmlspecialchars($button['type']) ?></button></div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

<?php include(erLhcoreClassDesign::designtpl('lhkernel/modal_footer.tpl.php')); ?>
