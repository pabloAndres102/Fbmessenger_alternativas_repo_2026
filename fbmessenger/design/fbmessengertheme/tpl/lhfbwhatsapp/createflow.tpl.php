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
        <h1><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Create a flow'); ?></h1>
    </center>
    <div class="tarjeta">

        <form method="POST" action="<?php echo erLhcoreClassDesign::baseurl('fbwhatsapp/createflow') ?>">
            <label for="nombre"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Name'); ?></label>
            <input type="text" id="name_flow" name="name_flow" required><br>
            <label for="categorie"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Category'); ?></label>
            <select id="categorie" name="categorie" required>
                <option value="SIGN_UP"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Sign up'); ?></option>
                <option value="SIGN_IN"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Sign in'); ?></option>
                <option value="APPOINTMENT_BOOKING"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Appointment booking'); ?></option>
                <option value="LEAD_GENERATION"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Lead generation'); ?></option>
                <option value="CONTACT_US"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Contact us'); ?></option>
                <option value="CUSTOMER_SUPPORT"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Customer support'); ?></option>
                <option value="SURVEY"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Survey'); ?></option>
                <option value="OTHER"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Other'); ?></option>
            </select><br><br><br>
            <button type="submit" class="btn btn-success"><span class="material-icons">add_circle_outline</span><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Create'); ?></button>        
        </form>
    </div>

</body>

</html>