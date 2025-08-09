<style>
    .tarjeta {
        border: 1px solid #ddd;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 30px;
        text-align: left;
        max-width: 500px;
        margin: 20px auto;
        background-color: #ffffff;
    }

    .tarjeta input[type="text"],
    .tarjeta input[type="number"],
    .tarjeta input[type="color"],
    .tarjeta select {
        width: calc(100% - 20px);
        padding: 12px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 6px;
        box-sizing: border-box;
        font-size: 16px;
        transition: border-color 0.3s ease;
    }

    .tarjeta input[type="text"]:focus,
    .tarjeta input[type="number"]:focus,
    .tarjeta input[type="color"]:focus,
    .tarjeta select:focus {
        border-color: #007bff;
        outline: none;
    }

    .tarjeta label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        font-size: 14px;
        color: #333;
    }

    .tarjeta button[type="submit"] {
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 6px;
        background-color: #007bff;
        color: #ffffff;
        font-size: 16px;
        cursor: pointer;
        margin-top: 20px;
        transition: background-color 0.3s ease;
    }

    .tarjeta button[type="submit"]:hover {
        background-color: #0056b3;
    }

    .tarjeta .material-icons {
        vertical-align: middle;
        margin-right: 5px;
    }
</style>

<div class="tarjeta">
    <form method="POST" action="<?php echo erLhcoreClassDesign::baseurl('fbwhatsappmessaging/kanban_new') ?>">
        <label for="name_status"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Name'); ?></label>
        <input type="text" id="name_status" name="name_status" required>
        
        <label for="position">Posición</label>
        <input type="number" id="position" name="position" required>
        
        <label for="color">Color</label>
        <input type="color" id="color" name="color">
        
        <button type="submit" class="btn btn-success">
            <span class="material-icons">add_circle_outline</span>
            <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Create'); ?>
        </button>
    </form>
</div>
