<style>
    h1,
    h2.fs-4 {
        font-weight: 600;
    }

    .search-form {
        max-width: 100%;
        margin-bottom: 1rem;
        display: flex;
        justify-content: flex-start;
    }

    .input-group {
        display: flex;
        gap: 10px;
        width: 100%;
    }

    .form-control,
    .form-select {
        flex: 1;
        padding: 10px;
        border: 1px solid #ced4da;
        border-radius: 8px;
        font-size: 0.95rem;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, .25);
    }

    .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .btn-primary,
    .btn-outline-primary:hover {
        background-color: #3b82f6;
        border-color: #3b82f6;
        box-shadow: 0 2px 6px rgba(59, 130, 246, .3);
    }

    .table {
        border-radius: 12px;
        overflow: hidden;
        font-size: 0.95rem;
    }

    .table thead {
        font-weight: 600;
    }

    .card {
        border-radius: 12px;
    }

    .components-column {
        max-width: 320px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .badge {
        font-weight: 500;
        font-size: 0.8rem;
        border-radius: 8px;
        padding: 6px 10px;
    }

    .icon {
        font-size: 18px;
        vertical-align: middle;
    }

    .text-link {
        text-decoration: none;
        font-weight: 500;
    }

    .text-link:hover {
        text-decoration: underline;
    }
</style>

<body>
    <h2 class="fs-4 mb-3 d-flex align-items-center gap-2">
        <span class="material-icons icon">description</span>
        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Templates'); ?>
    </h2>

    <div class="row g-2 mb-3 align-items-center">

        <!-- Columna izquierda: Acciones compactas -->
        <div class="col-md-6">
            <div class="d-grid gap-2">
                <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsapp/create'); ?>"
                    class="btn btn-outline-primary btn-sm d-flex align-items-center justify-content-center gap-1">
                    <span class="material-icons" style="font-size:18px;">add</span>
                    <span>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Create template'); ?>
                    </span>
                </a>

                <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsapp/carousel'); ?>"
                    class="btn btn-outline-primary btn-sm d-flex align-items-center justify-content-center gap-1">
                    <span class="material-icons" style="font-size:18px;">view_carousel</span>
                    <span>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Create carousel'); ?>
                    </span>
                </a>
            </div>
        </div>

        <!-- Columna derecha: Estados compactos -->
        <div class="col-md-6">
            <div class="card border-0 bg-light h-100">
                <div class="card-body p-2">
                    <small class="d-flex flex-column gap-1 text-muted">

                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-success">Aprobada</span>
                            <span>Lista para envío</span>
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-warning text-dark">Pendiente</span>
                            <span>En revisión</span>
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-danger">Rechazada</span>
                            <span>No aprobada</span>
                        </div>

                    </small>
                </div>
            </div>
        </div>

    </div>



    <?php
    // Comprueba si hay un mensaje de éxito en la variable de sesión
    if (isset($_SESSION['delete_template_message'])) {
        echo '<div class="alert alert-success">' . $_SESSION['delete_template_message'] . '</div>';
        // Elimina el mensaje de éxito de la variable de sesión para que no se muestre nuevamente después de la recarga
        unset($_SESSION['delete_template_message']);
    }

    // Comprueba si hay un mensaje de error en la variable de sesión
    if (isset($_SESSION['delete_template_error'])) {
        echo '<div class="alert alert-danger">' . $_SESSION['delete_template_error'] . '</div>';
        unset($_SESSION['delete_template_error']);
    }

    if (isset($_SESSION['api_error'])) {
        if (isset($_SESSION['api_error']['error']['message'])) {
            echo '<div class="alert alert-danger">' . $_SESSION['api_error']['error']['message'] . '</div>';
            if (isset($_SESSION['api_error']['error']['error_user_msg'])) {
                echo '<div class="alert alert-danger">' . $_SESSION['api_error']['error']['error_user_msg'] . '</div>';
            }
        } else {
            echo '<div class="alert alert-danger">' . $_SESSION['api_error'] . '</div>';
        }
        unset($_SESSION['api_error']);
    }

    if (isset($_SESSION['api_response'])) {
        $apiResponse = $_SESSION['api_response'];

        // Accede a campos específicos del JSON
        $id = $apiResponse['id'];
        $status = $apiResponse['status'];
        $category = $apiResponse['category'];

        // Mapea los valores de status a representaciones en español
        $statusMap = array(
            'PENDING' => 'PENDIENTE',
            'APPROVED' => 'APROBADA',
            'REJECTED' => 'RECHAZADA'
        );
        $categoryMap = array(
            'MARKETING' => 'MARKETING',
            'UTILITY' => 'UTILIDAD',
            'AUTHENTICATION' => 'AUTENTICACIÓN'
        );

        if (array_key_exists($category, $categoryMap)) {
            $categoryLegible = $categoryMap[$category];
        } else {
            $categoryLegible = $category; // Si no está en el mapa, muestra el valor original
        }

        // Verifica si el valor de status está en el mapa
        if (array_key_exists($status, $statusMap)) {
            $statusLegible = $statusMap[$status];
        } else {
            $statusLegible = $status; // Si no está en el mapa, muestra el valor original
        }

        echo '<div class="alert alert-success">';
        echo '<h4>Su plantilla se ha creado con éxito</h4>';
        echo '<div class="response-details">';
        echo '<p><strong>ID de plantilla:</strong> ' . $id . '</p>';
        echo '<p><strong>Estado:</strong> ' . $statusLegible . '</p>';
        echo '<p><strong>Categoría:</strong> ' . $categoryLegible  . '</p>';
        echo '</div>';
        echo '</div>'; // Cierra div class="alert alert-success"

        unset($_SESSION['api_response']);
    }
    ?>
    <form method="GET" action="<?php echo erLhcoreClassDesign::baseurl('fbwhatsapp/templates'); ?>" class="search-form mb-3">
        <div class="input-group">
            <input type="text" name="search_name" placeholder="Nombre" value="<?php echo htmlspecialchars($_GET['search_name'] ?? ''); ?>" class="form-control" />
            <select name="search_category" class="form-select">
                <option value="">Categoría</option>
                <option value="MARKETING" <?php echo (($_GET['search_category'] ?? '') == 'MARKETING') ? 'selected' : ''; ?>>Marketing</option>
                <option value="UTILITY" <?php echo (($_GET['search_category'] ?? '') == 'UTILITY') ? 'selected' : ''; ?>>Utilidad</option>
                <option value="AUTHENTICATION" <?php echo (($_GET['search_category'] ?? '') == 'AUTHENTICATION') ? 'selected' : ''; ?>>Autenticación</option>
            </select>
            <select class="form-select" id="language" name="search_language" aria-label="Seleccionar idioma">
                <option value="es" selected>Español</option>
                <option value="af">Afrikáans</option>
                <option value="sq">Albanés</option>
                <option value="ar">Árabe</option>
                <option value="az">Azerí</option>
                <option value="bn">Bengalí</option>
                <option value="bg">Búlgaro</option>
                <option value="ca">Catalán</option>
                <option value="zh_CN">Chino (China)</option>
                <option value="zh_HK">Chino (Hong Kong)</option>
                <option value="zh_TW">Chino (Tailandia)</option>
                <option value="cs">Checo</option>
                <option value="nl">Holandés</option>
                <option value="en_US">Inglés</option>
                <option value="en_GB">Inglés (Reino Unido)</option>
                <option value="es_LA">Español (EE. UU.)</option>
                <option value="et">Estonio</option>
                <option value="fil">Filipino</option>
                <option value="fi">Finlandés</option>
                <option value="fr">Francés</option>
                <option value="de">Alemán</option>
                <option value="el">Griego</option>
                <option value="gu">Guyaratí</option>
                <option value="he">Hebreo</option>
                <option value="hi">Hindi</option>
                <option value="hu">Húngaro</option>
                <option value="id">Indonesio</option>
                <option value="ga">Irlandés</option>
                <option value="it">Italiano</option>
                <option value="ja">Japonés</option>
                <option value="kn">Canarés</option>
                <option value="kk">Kazajo</option>
                <option value="ko">Coreano</option>
                <option value="lo">Lao</option>
                <option value="lv">Letón</option>
                <option value="lt">Lituano</option>
                <option value="mk">Macedonio</option>
                <option value="ms">Malayo</option>
                <option value="mr">Maratí</option>
                <option value="nb">Noruego</option>
                <option value="fa">Persa</option>
                <option value="pl">Polaco</option>
                <option value="pt_BR">Portugués (Brasil)</option>
                <option value="pt_PT">Portugués (Portugal)</option>
                <option value="pa">Punyabí</option>
                <option value="ro">Rumano</option>
                <option value="ru">Ruso</option>
                <option value="sr">Serbio</option>
                <option value="sk">Eslovaco</option>
                <option value="sl">Esloveno</option>
                <option value="es_AR">Español (Argentina)</option>
                <option value="es_ES">Español (España)</option>
                <option value="es_MX">Español (México)</option>
                <option value="sw">Suajili</option>
                <option value="sv">Sueco</option>
                <option value="ta">Tamil</option>
                <option value="te">Telugu</option>
                <option value="th">Tailandés</option>
                <option value="tr">Turco</option>
                <option value="uk">Ucraniano</option>
                <option value="ur">Urdu</option>
                <option value="uz">Uzbeko</option>
                <option value="vi">Vietnamita</option>
            </select>

            <select name="search_status" class="form-select">
                <option value="">Estado</option>
                <option value="APPROVED" style="color: green;" <?php echo (($_GET['search_status'] ?? '') == 'APPROVED') ? 'selected' : ''; ?>>Aprobado</option>
                <option value="PENDING" style="color: rgba(255, 215, 0, 0.6);" <?php echo (($_GET['search_status'] ?? '') == 'PENDING') ? 'selected' : ''; ?>>Pendiente</option> <!-- Amarillo más opaco -->
                <option value="REJECTED" style="color: red;" <?php echo (($_GET['search_status'] ?? '') == 'REJECTED') ? 'selected' : ''; ?>>Rechazado</option>
            </select>


            <button type="submit" class="btn btn-primary">Buscar</button>
            <a href="<?php echo erLhcoreClassDesign::baseurl('fbwhatsapp/templates'); ?>" class="btn btn-primary d-flex align-items-center">
                <span class="material-icons">undo</span>
            </a>
        </div>
    </form>
    <?php include(erLhcoreClassDesign::designtpl('lhkernel/paginator.tpl.php')); ?>
    <table class="table table-sm" ng-non-bindable>
        <thead>
            <tr>
                <th>📛 <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Name'); ?></th>
                <th>🏷️ <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('abstract/proactivechatinvitation', 'Category') ?></th>
                <th>📦 <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Template type') ?></th>
                <th>🧩 <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('file/file', 'Content') ?></th>
                <th>📅 <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Fecha de creación'); ?></th>
                <th>🔄 <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/pendingchats', 'Status') ?></th>
                <th>🌐 <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Idioma') ?></th>
                <th>⚙️ <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Lista de nombres de plantillas a excluir
            $excludedTemplates = array(
                'sample_purchase_feedback',
                'sample_issue_resolution',
                'sample_flight_confirmation',
                'sample_shipping_confirmation',
                'sample_happy_hour_announcement',
                'sample_movie_ticket_confirmation'
            );

            foreach ($templates as $template) :
                // Verifica si el nombre de la plantilla está en la lista de exclusiones
                if (!in_array($template['name'], $excludedTemplates)) :
            ?>
                    <tr>
                        <td>
                            <?php echo htmlspecialchars($template['name']) ?>
                        </td>
                        <td>
                            <?php
                            $category = htmlspecialchars($template['category']);
                            // Mostrar categorías en mayúsculas y en español
                            if ($category == 'MARKETING') {
                                echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'MARKETING');
                            } elseif ($category == 'UTILITY') {
                                echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'UTILITY');
                            } elseif ($category == 'AUTHENTICATION') {
                                echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'AUTHENTICATION');
                            } else {
                                echo $category; // Mostrar categoría original si no coincide con las categorías hardcoded
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            $templateType = ''; // Variable para almacenar el tipo de plantilla
                            foreach ($template['components'] as $component) {
                                if ($component['type'] == 'CAROUSEL') {
                                    $templateType = 'CARRUSEL';
                                } elseif ($component['type'] == 'LIMITED_TIME_OFFER') {
                                    $templateType = 'OFERTA';
                                }
                                foreach ($component['buttons'] as $buttons) {
                                    if ($buttons['type'] == 'MPM') {
                                        $templateType = 'MULTIPRODUCTO';
                                    }
                                    if ($buttons['type'] == 'CATALOG') {
                                        $templateType = 'CATALOGO';
                                    }
                                }
                            }
                            if (empty($templateType)) {
                                $templateType = 'ESTÁNDAR';
                            }
                            echo htmlspecialchars($templateType);
                            ?>
                        </td>
                        <td class="components-column">
                            <?php $fieldsCount = 0;
                            $fieldsCountHeader = 0;
                            $fieldCountHeaderDocument = 0;
                            $fieldCountHeaderImage = 0;
                            $fieldCountHeaderVideo = 0; ?>
                            <h5 class="text-secondary">Idioma: <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', $template['language']); ?></h5>
                            <div class="rounded bg-light p-2" title="<?php echo htmlspecialchars(json_encode($template, JSON_PRETTY_PRINT)) ?>">
                                <?php foreach ($template['components'] as $component) : ?>
                                    <?php if ($component['type'] == 'HEADER' && $component['format'] == 'IMAGE' && isset($component['example']['header_url'][0])) : ?>
                                        <img src="<?php echo htmlspecialchars($component['example']['header_url'][0]) ?>" width="100px" />
                                    <?php endif; ?>
                                    <?php if ($component['type'] == 'HEADER' && $component['format'] == 'DOCUMENT' && isset($component['example']['header_url'][0])) : ?>
                                        <div>
                                            <span class="badge badge-secondary">FILE: <?php echo htmlspecialchars($component['example']['header_url'][0]) ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($component['type'] == 'HEADER' && $component['format'] == 'VIDEO' && isset($component['example']['header_url'][0])) : ?>
                                        <div>
                                            <span class="badge badge-secondary">VIDEO: <?php echo htmlspecialchars($component['example']['header_url'][0]) ?></span>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <?php foreach ($template['components'] as $component) : ?>
                                    <?php if ($component['type'] == 'BODY') :
                                        $matchesReplace = [];
                                        preg_match_all('/\{\{[0-9]\}\}/is', $component['text'], $matchesReplace);
                                        if (isset($matchesReplace[0])) {
                                            $fieldsCount = count($matchesReplace[0]);
                                        }
                                    ?><p><?php echo htmlspecialchars($component['text']) ?></p><?php endif; ?>
                                    <?php if ($component['type'] == 'HEADER') : ?>
                                        <?php if ($component['format'] == 'DOCUMENT') : $fieldCountHeaderDocument = 1; ?>
                                            <!-- <h5 class="text-secondary">DOCUMENT</h5> -->

                                        <?php elseif ($component['format'] == 'VIDEO') : $fieldCountHeaderVideo = 1; ?>
                                            <!-- <h5 class="text-secondary">VIDEO</h5> -->

                                            <?php if (isset($component['example']['header_handle'][0])) : ?>
                                                <video width="100">
                                                    <source src="<?php echo htmlspecialchars($component['example']['header_handle'][0]) ?>" type="video/mp4">
                                                </video>
                                            <?php endif; ?>
                                        <?php elseif ($component['format'] == 'IMAGE') : $fieldCountHeaderImage = 1; ?>
                                            <!-- <h5 class="text-secondary">IMAGE</h5> -->

                                            <?php if (isset($component['example']['header_handle'][0])) : ?>
                                                <img src="<?php echo htmlspecialchars($component['example']['header_handle'][0]) ?>" width="100px" />
                                            <?php endif; ?>
                                        <?php else : ?>
                                            <?php
                                            $matchesReplace = [];
                                            preg_match_all('/\{\{[0-9]\}\}/is', $component['text'], $matchesReplace);
                                            if (isset($matchesReplace[0])) {
                                                $fieldsCountHeader = count($matchesReplace[0]);
                                            }
                                            ?>
                                            <h5 class="text-secondary"><?php echo htmlspecialchars($component['text']) ?></h5>
                                        <?php endif; ?>

                                    <?php endif; ?>
                                    <?php if ($component['type'] == 'FOOTER') : ?><p class="text-secondary"><?php echo htmlspecialchars($component['text']) ?></p><?php endif; ?>
                                    <?php if ($component['type'] == 'BUTTONS') : ?>
                                        <?php foreach ($component['buttons'] as $button) : ?>
                                            <div class="pb-2"><button class="btn btn-sm btn-secondary"><?php echo htmlspecialchars($button['text']) ?> | <?php echo htmlspecialchars($button['type']) ?></button></div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </td>
                        <td>
                            <?php if (isset($template['created_at'])) : ?>
                                <?php echo gmdate('Y-m-d H:i:s', $template['created_at'] - (5 * 3600)); ?>
                            <?php else : ?>
                                Fuera de rango
                            <?php endif; ?>
                        </td>

                        <td>
                            <?php
                            $status = htmlspecialchars($template['status']);
                            $translation = erTranslationClassLhTranslation::getInstance();

                            if ($status == 'APPROVED') {
                                echo '<span style="color: green;">' . $translation->getTranslation('module/fbmessenger', 'APPROVED') . '</span>';
                            } elseif ($status == 'PENDING') {
                                echo '<span style="color: yellow;">' . $translation->getTranslation('module/fbmessenger', 'PENDING') . '</span>';
                            } elseif ($status == 'REJECTED') {
                                echo '<span style="color: red;">' . $translation->getTranslation('module/fbmessenger', 'REJECTED') . '</span>';
                                echo '<br>';
                                $reason = '';
                                $tooltip = '';

                                if ($template['rejected_reason'] == 'ABUSIVE_CONTENT') {
                                    $reason = $translation->getTranslation('module/fbmessenger', 'ABUSIVE_CONTENT');
                                    $tooltip = $translation->getTranslation('module/fbmessenger', 'ABUSIVE_CONTENT_TOOLTIP');
                                } elseif ($template['rejected_reason'] == 'INVALID_FORMAT') {
                                    $reason = $translation->getTranslation('module/fbmessenger', 'INVALID_FORMAT');
                                    $tooltip = $translation->getTranslation('module/fbmessenger', 'INVALID_FORMAT_TOOLTIP');
                                } elseif ($template['rejected_reason'] == 'NONE') {
                                    $reason = $translation->getTranslation('module/fbmessenger', 'NONE');
                                    $tooltip = $translation->getTranslation('module/fbmessenger', 'NONE_TOOLTIP');
                                } elseif ($template['rejected_reason'] == 'PROMOTIONAL') {
                                    $reason = $translation->getTranslation('module/fbmessenger', 'PROMOTIONAL');
                                    $tooltip = $translation->getTranslation('module/fbmessenger', 'PROMOTIONAL_TOOLTIP');
                                } elseif ($template['rejected_reason'] == 'TAG_CONTENT_MISMATCH') {
                                    $reason = $translation->getTranslation('module/fbmessenger', 'TAG_CONTENT_MISMATCH');
                                    $tooltip = $translation->getTranslation('module/fbmessenger', 'TAG_CONTENT_MISMATCH_TOOLTIP');
                                } elseif ($template['rejected_reason'] == 'SCAM') {
                                    $reason = $translation->getTranslation('module/fbmessenger', 'SCAM');
                                    $tooltip = $translation->getTranslation('module/fbmessenger', 'SCAM_TOOLTIP');
                                }

                                if ($reason) {
                                    // Icono de ayuda con tooltip
                                    echo '<span class="tooltip-container" title="' . htmlspecialchars($tooltip) . '">';
                                    echo '<span class="material-icons">help</span>';
                                    echo $reason;
                                    echo '</span>';
                                }
                            } else {
                                echo htmlspecialchars($template['status']);
                            }
                            ?>
                        </td>
                        <td>
                            <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', $template['language']); ?>
                        </td>
                        <td>

                            <form method="post"
                                action="<?php echo erLhcoreClassDesign::baseurl('fbwhatsapp/delete') ?>"
                                style="display:inline-block; margin-right:5px;"
                                onsubmit="return confirm('¿Confirmas que quieres eliminar esta plantilla de mensaje? No podrás usar el nombre <?php echo htmlspecialchars($template['name']); ?> para ninguna plantilla de mensaje nueva que crees mientras se elimina.');">
                                <input type="hidden" name="template_name" value="<?php echo htmlspecialchars_decode($template['name']); ?>">
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <span class="material-icons" style="vertical-align: middle;">delete</span>
                                    <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Delete'); ?>
                                </button>
                            </form>


                            <form method="get"
                                action="<?php echo erLhcoreClassDesign::baseurl('fbwhatsapp/metric_templates') ?>"
                                style="display:inline-block;">
                                <input type="hidden" name="template_id" value="<?php echo htmlspecialchars_decode($template['id']); ?>">
                                <button type="submit" class="btn btn-outline-info btn-sm">
                                    <span class="material-icons" style="vertical-align: middle;">equalizer</span>
                                    <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Metrics'); ?>
                                </button>
                            </form>
                        </td>

                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>