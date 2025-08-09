<style>
    .custom-card {
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        background-color: #fff;
    }
    .profile-placeholder {
        width: 100px;
        /* Ajusta el tamaño según sea necesario */
        height: 100px;
        /* Ajusta el tamaño según sea necesario */
        background-color: #ddd;
        /* Color de fondo para la imagen */
        color: #666;
        /* Color del texto */
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        /* Tamaño del texto */
        border-radius: 50%;
        /* Forma circular */
        text-align: center;
        border: 2px dashed #bbb;
        /* Borde opcional */
    }

    .card {
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        padding: 20px;
        margin: 20px;
        text-align: center;
        height: 100%;
        /* Set a fixed height for the card */
    }

    .card img {
        max-width: 100%;
        /* Make the image responsive within the card */
        max-height: 100%;
        /* Set your desired max height for the image */
        border-radius: 8px;
    }

    .custom-card {
        margin: 20px;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    }

    .attr-header {
        color: black;
    }

    @media (max-width: 767px) {
        .custom-card {
            margin: 10px;
            padding: 10px;
        }

        .col-md-6,
        .col-md-10 {
            width: 100%;
        }
    }
</style>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="custom-card p-4">
                <h3 class="text-center mb-4"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Select Phone'); ?></h3>
                <form method="post" action=<?php echo erLhcoreClassDesign::baseurl('fbwhatsapp/profilebusiness') ?>>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Phone'); ?></span>
                        </div>
                        <select name="phone" id="phone" class="form-control">
                            <?php foreach ($phones as $phone) : ?>
                                <option value="<?php echo htmlspecialchars($phone); ?>">
                                    <?php echo htmlspecialchars($phone); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">
                            <span class="material-icons">cloud</span><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Load Profile'); ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-10 offset-md-2">
        <div class="col-md-10 custom-card">
                <?php if (isset($_SESSION['profile_success'])) : ?>
                    <!-- Mostrar mensaje de éxito -->
                    <div class="alert alert-success">
                        <?php echo $_SESSION['profile_success']; ?>
                    </div>
                    <?php unset($_SESSION['profile_success']); // Limpiar la sesión después de mostrar el mensaje ?>
                <?php elseif (isset($_SESSION['profile_error'])) : ?>
                    <!-- Mostrar mensaje de error -->
                    <div class="alert alert-danger">
                        <?php echo $_SESSION['profile_error']; ?>
                        <?php if (isset($_SESSION['profile_error2'])) : ?>
                            <br><?php echo $_SESSION['profile_error2']; ?>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['profile_error3'])) : ?>
                            <br><strong><?php echo $_SESSION['profile_error3']; ?></strong>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['profile_error4'])) : ?>
                            <br><?php echo $_SESSION['profile_error4']; ?>
                        <?php endif; ?>
                    </div>
                    <?php
                    unset($_SESSION['profile_error']);
                    unset($_SESSION['profile_error2']);
                    unset($_SESSION['profile_error3']);
                    unset($_SESSION['profile_error4']);
                    ?>
                <?php elseif (isset($_SESSION['profile_unknown_error'])) : ?>
                    <!-- Mostrar mensaje de error desconocido -->
                    <div class="alert alert-warning">
                        <?php echo $_SESSION['profile_unknown_error']; ?>
                    </div>
                    <?php unset($_SESSION['profile_unknown_error']); ?>
                <?php else : ?>
                    <!-- Mostrar el formulario si no hay mensaje de éxito o error -->
                    <h3 class="text-center mb-4"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Update business profile'); ?></h3>
                    <div class="custom-card p-4">
                        <?php
                        if (isset($_SESSION['phone'])) {
                            $variable = $_SESSION['phone'];
                            unset($_SESSION['phone']);
                        }
                        ?>

                        <form method="POST" action=<?php echo erLhcoreClassDesign::baseurl('fbwhatsapp/profilebusiness') ?> enctype="multipart/form-data">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'About'); ?></span>
                                </div>
                                <textarea class="form-control" name="about" aria-label="With textarea" required><?php echo (isset($config['data'][0]['about'])) ? htmlspecialchars($config['data'][0]['about']) : ''; ?></textarea>
                                <input type="hidden" name="phone_profile" value="<?php echo htmlspecialchars($variable ?? ''); ?>">
                            </div>
                            <br>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Address'); ?></span>
                                </div>
                                <input type="text" class="form-control" name="address" value="<?php echo (isset($config['data'][0]['address'])) ? htmlspecialchars($config['data'][0]['address']) : ''; ?>" aria-label="Username" aria-describedby="basic-addon1">
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Description'); ?></span>
                                </div>
                                <textarea class="form-control" name="description" aria-label="With textarea"><?php echo (isset($config['data'][0]['description'])) ? htmlspecialchars($config['data'][0]['description']) : ''; ?></textarea>
                            </div>
                            <br>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Email'); ?></span>
                                </div>
                                <input type="email" name="email" class="form-control" value="<?php echo (isset($config['data'][0]['email'])) ? htmlspecialchars($config['data'][0]['email']) : ''; ?>" aria-label="Username" aria-describedby="basic-addon1">
                            </div>

                            <div class="input-group mb-3">
                                <label for="image"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Profile image'); ?>
                                    <input type="file" name="image" class="form-control" id="basic-url" aria-describedby="basic-addon3">
                                    <span><small><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Update business profile'); ?> Asegúrese de haber ingresado el identificador de la app para actualizar la imagen del perfil de WhatsApp.
                                            haga click <a href="<?php echo erLhcoreClassDesign::baseurl('fbmessenger/options') ?>"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Aqui'); ?></a> para ingresarlo
                                        </small></span>
                                </label>
                            </div>

                            <div class="card mb-3">
                                <h2><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Whatsapp profile'); ?></h2>
                                <?php if (!empty($config['data'][0]['profile_picture_url'])) : ?>
                                    <img src="<?php echo htmlspecialchars($config['data'][0]['profile_picture_url']); ?>" alt="Perfil de WhatsApp">
                                <?php else : ?>
                                    <center>
                                        <div class="profile-placeholder">Empty</div>
                                    </center>
                                <?php endif; ?>
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="inputGroupSelect01">Vertical</label>
                                </div>
                                <select class="custom-select" id="inputGroupSelect01" name="vertical">
                                    <option value=""><?php echo (isset($config['data'][0]['vertical'])) ? htmlspecialchars($config['data'][0]['vertical']) : ''; ?></option>
                                    <option value="AUTO">Servicio automotor</option>
                                    <option value="OTHER">Otro</option>
                                    <option value="BEAUTY">Belleza, cosmética y cuidado personal</option>
                                    <option value="APPAREL">Indumentaria y accesorios</option>
                                    <option value="EDU">Educación</option>
                                    <option value="ENTERTAIN">Arte y entretenimiento</option>
                                    <option value="EVENT_PLAN">Organizador@ de eventos</option>
                                    <option value="FINANCE">Finanzas</option>
                                    <option value="GROCERY">Tienda de comestibles</option>
                                    <option value="GOVT">Servicio público y gubernamental</option>
                                    <option value="HOTEL">Hotel</option>
                                    <option value="HEALTH">Medicina y salud</option>
                                    <option value="NONPROFIT">Organización sin fines de lucro</option>
                                    <option value="RETAIL">Compras y ventas minoristas</option>
                                    <option value="PROF_SERVICES">Servicio profesional</option>
                                    <option value="TRAVEL">Viajes y transporte</option>
                                    <option value="RESTAURANT">Restaurante</option>
                                </select>
                            </div>

                            <div class="container mt-5">
                                <div class="row justify-content-center">
                                    <div class="col-md-10">
                                        <h3 class="text-center mb-4"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Websites'); ?></h3>
                                        <div class="form-group">
                                            <label for="website1"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Website'); ?> 1:</label>
                                            <input type="url" class="form-control" id="website1" name="website1" value="<?php echo isset($config['data'][0]['websites'][0]) ? htmlspecialchars($config['data'][0]['websites'][0]) : ''; ?>" placeholder="https://www.ejemplo.com">
                                        </div>
                                        <div class="form-group">
                                            <label for="website2"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Website'); ?> 2:</label>
                                            <input type="url" class="form-control" id="website2" name="website2" value="<?php echo isset($config['data'][0]['websites'][1]) ? htmlspecialchars($config['data'][0]['websites'][1]) : ''; ?>" placeholder="https://www.otroejemplo.com">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <center><button type="submit" class="btn btn-primary"> <span class="material-icons">save</span><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('system/buttons', 'Save'); ?></button></center>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
            <br>
            <br>
        </div>
            <br>
            <br>
        </div>
    </div>
</div>

</body>