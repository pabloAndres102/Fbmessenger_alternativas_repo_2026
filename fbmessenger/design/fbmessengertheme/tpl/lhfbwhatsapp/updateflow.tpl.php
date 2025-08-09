<html>

<head>
    <style>
        .tarjeta {
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            padding: 20px;
            text-align: center;
            width: 400px;
            margin: 0 auto;
            /* Centra horizontalmente */
        }

        .tarjeta input[type="text"],
        .tarjeta input[type="submit"],
        .tarjeta select {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .tarjeta label {
            text-align: left;
            display: block;
            margin-bottom: 5px;
        }

        /* Estilo para el select */
        .tarjeta select {
            width: 100%;
            /* Hacer que el select ocupe todo el ancho */
            padding: 10px;
            background-color: #f5f5f5;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>


</head>

<body>
    <center>
        <h1><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Update a flow'); ?></h1>
    </center>
    <?php
    // Recuperar el valor de flow_id de la URL
    $flow_id = isset($_GET['flow_id']) ? htmlspecialchars($_GET['flow_id']) : '';
    ?>
    <div class="tarjeta">

        <form method="POST" action="<?php echo erLhcoreClassDesign::baseurl('fbwhatsapp/updateflow') ?>" enctype="multipart/form-data">

            <label for="flow_id"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Flow id'); ?></label>
            <input type="text" id="flow_id" name="flow_id" value="<?php echo $flow_id; ?>"><br>


            <div class="input-group mb-3">
                <label for="json_file"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Upload a json file'); ?>
                    <input type="file" name="json_file" class="form-control">
                </label>
            </div>
            <br><br><br>
            <button class="btn btn-warning">
                <span class="material-icons">system_security_update_good</span>
                <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('system/buttons', 'Update'); ?>
    </button>

        </form>
    </div>

</body>

</html>