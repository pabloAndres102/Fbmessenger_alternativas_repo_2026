<?php /*
<pre><?php print_r($template);?></pre>
*/ ?>
<style>
    /* Estilos para el campo de fecha */
    .date-input {
        border: 1px solid #ced4da;
        border-radius: 4px;
        padding: 6px 12px;
        margin-bottom: 10px;
        /* Agrega cualquier otro estilo que desees */
    }

    .form-control {
        /* Estilos para los inputs */
        border: 1px solid #ced4da;
        border-radius: 4px;
        padding: 6px 12px;
        margin-bottom: 10px;
    }

    .btn-add {
        /* Estilos para el botón de agregar */
        background-color: #007bff;
        border-color: #007bff;
        color: #fff;
        padding: 6px 12px;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-add:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .btn-beige {
        background-color: beige;
        color: #212529;
        /* Ajusta el color del texto según tu diseño */
        border-color: beige;
    }

    .btn-beige:hover {
        background-color: #e6d9b8;
        /* Color de hover */
        border-color: #e6d9b8;
        /* Color del borde al hacer hover */
    }
</style>
<?php $products = erLhcoreClassModelCatalogProducts::getList(); ?>
<h6><strong>Nombre de plantilla: </strong><?php echo htmlspecialchars($template['name']) ?></h6>
<h6><strong>Categoria de plantilla: </strong><span style="color: black;" class="badge badge-secondary"><?php echo htmlspecialchars($template['category']) ?></span></h6>
<h6><strong>Nombre de plantilla: </strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', $template['language']); ?></h6>

<?php $fieldsCount = 0;
$fieldsCountHeader = 0;
$fieldCountHeaderDocument = 0;
$fieldCountHeaderImage = 0;
$fieldCountHeaderVideo = 0;
$buttonsMPM = 0;
$allowedExtensions = [];


foreach ($template['components'] as $component) {
    if ($component['type'] == 'HEADER' && $component['format'] == 'IMAGE') {
        // Si el header es una imagen, agrega las extensiones de imagen permitidas
        $allowedExtensions = array_merge($allowedExtensions, ['jpg', 'jpeg', 'png']);
    }
    if ($component['type'] == 'HEADER' && $component['format'] == 'VIDEO') {
        // Si el header es un video, agrega la extensión de video permitida
        $allowedExtensions[] = 'mp4';
    }
    if ($component['type'] == 'CAROUSEL') {
        foreach ($component['cards'] as $card) {
            $header_type = $card['components'][0]['type'];
            if ($header_type == 'HEADER' && $card['components'][0]['format'] == 'IMAGE') {
                $allowedExtensions = array_merge($allowedExtensions, ['jpg', 'jpeg', 'png']);
            }
            if ($header_type == 'HEADER' && $card['components'][0]['format'] == 'VIDEO') {
                $allowedExtensions[] = 'mp4';
            }
        }
    }
}
echo '<script>';
echo 'const allowedExtensions = ' . json_encode($allowedExtensions) . ';';
echo '</script>';

?>


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
    <?php
    foreach ($template['components'] as $component) :
        if ($component['type'] === 'CAROUSEL' && isset($component['cards']) && is_array($component['cards'])) : ?>
            <h5><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Carousel'); ?></h5>
            <?php foreach ($component['cards'] as $card) : ?>
                <?php foreach ($card['components'] as $cardComponent) : ?>
                    <?php if ($cardComponent['type'] == 'BODY') : ?>
                        <p><?php echo htmlspecialchars($cardComponent['text']) ?></p>
                    <?php endif; ?>
                    <?php if ($cardComponent['type'] == 'BUTTONS') : ?>
                        <?php foreach ($cardComponent['buttons'] as $button) : ?>
                            <div class="pb-2"><button class="btn btn-sm btn-secondary"><?php echo htmlspecialchars($button['text']) ?> | <?php echo htmlspecialchars($button['type']) ?></button></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if ($cardComponent['format'] == 'VIDEO') : ?>
                        <video width="100">
                            <source src="<?php echo htmlspecialchars($cardComponent['example']['header_handle'][0]) ?>" type="video/mp4">
                        </video>
                    <?php endif; ?>
                    <?php if ($cardComponent['format'] == 'IMAGE') : ?>
                        <img src="<?php print_r($cardComponent['example']['header_handle'][0]) ?>" width="100px">
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endforeach; ?>

</div>



<!--=========||=========-->
<div class="row">
    <div class="row">
        <?php for ($i = 0; $i < $fieldsCount; $i++) : ?>
            <div class="col-6 mb-3" ng-non-bindable>
                <label class="font-weight-bold">Campo de texto - {{<?php echo $i + 1 ?>}}</label>
                <div class="input-group">

                    <input type="text" list="fields_placeholders" class="form-control form-control-sm" id="field_<?php echo $i + 1 ?>" name="field_<?php echo $i + 1 ?>" value="<?php if (isset($data['field_' .  ($i + 1)])) {
                                                                                                                                                                                    echo htmlspecialchars($data['field_' .  ($i + 1)]);
                                                                                                                                                                                } ?>">
                </div>
            </div>
        <?php endfor; ?>
    </div>
    <?php for ($i = 0; $i < $fieldsCountHeader; $i++) : ?>
        <div class="col-6" ng-non-bindable>
            <div class="form-group">
                <label class="font-weight-bold">Campo de encabezado - {{<?php echo $i + 1 ?>}}</label>
                <div class="input-group">
                    <input type="text" list="fields_placeholders" class="form-control form-control-sm" id="field_header_<?php echo $i + 1 ?>" name="field_header_<?php echo $i + 1 ?>" value="<?php if (isset($data['field_header_' .  $i + 1])) : ?><?php echo htmlspecialchars($data['field_header_' .  $i + 1]) ?><?php endif; ?>">
                </div>
            </div>
        </div>
    <?php endfor; ?>

    <?php for ($i = 0; $i < $fieldCountHeaderDocument; $i++) : ?>
        <div class="col-6" ng-non-bindable>
            <div class="form-group">
                <label class="font-weight-bold">Campo de documento - {{<?php echo $i + 1 ?>}}</label>
                <div class="input-group">
                    <input type="file" id="image_general" name="image_general[]" class="form-control" required>
                    <div class="input-group-append">
                        <!-- <a data-selector="#field_header_doc_<?php echo $i + 1 ?>" class="fb-choose-file btn btn-sm btn-success" href="#">
                            <span class="material-icons">upload</span>
                            <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('file/list', 'Upload a file'); ?>
                        </a> -->
                    </div>
                </div>
            </div>
        </div>
    <?php endfor; ?>
    <?php for ($i = 0; $i < $fieldCountHeaderDocument; $i++) : ?>
        <div class="form-group">
            <label class="font-weight-bold">Nombre de archivo - {{<?php echo $i + 1 ?>}}</label>
            <input list="fields_placeholders" type="text" class="form-control form-control-sm" placeholder="filename.pdf" id="nombre_archivo<?php echo $i + 1 ?>" name="nombre_archivo<?php echo $i + 1 ?>" value="<?php if (isset($data['nombre_archivo' .  $i + 1])) : ?><?php echo htmlspecialchars($data['nombre_archivo' .  $i + 1]) ?><?php endif; ?>">
        <?php endfor; ?>



        <?php for ($i = 0; $i < $fieldCountHeaderImage; $i++) : ?>
            <div class="col-6" ng-non-bindable>
                <div class="form-group">
                    <label class="font-weight-bold">Campo de imagen <?php echo $i + 1 ?></label>
                    <div class="input-group"> <!-- Añadimos una clase input-group -->
                        <input type="file" id="image_general" name="image_general[]" class="form-control" required onchange="validateFile(this)">
                        <?php if (in_array('jpg', $allowedExtensions) && in_array('jpeg', $allowedExtensions) && in_array('png', $allowedExtensions)) : ?>
                            <span class="file-type-info">(Solo Imágenes: <span class="material-icons">image</span>)</span>
                        <?php endif; ?>
                        <div class="input-group-append">
                            <!-- <a data-selector="#field_header_img_<?php echo $i + 1 ?>" class="fb-choose-file btn btn-sm btn-success" href="#">
                                <span class="material-icons">upload</span>
                                <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('file/list', 'Upload a file'); ?>
                            </a> -->
                        </div>
                    </div>
                </div>
            </div>
        <?php endfor; ?>


        <?php for ($i = 0; $i < $fieldCountHeaderVideo; $i++) : ?>
            <div class="col-6" ng-non-bindable>
                <div class="form-group">
                    <label class="font-weight-bold">Campo de video URL <?php echo $i + 1 ?></label>
                    <div class="input-group"> <!-- Añadimos una clase input-group -->
                        <input type="file" id="image_general" name="image_general[]" class="form-control" required onchange="validateFile(this)">
                        <?php if (in_array('mp4', $allowedExtensions)) : ?>
                            <span class="file-type-info">(Solo Videos: <span class="material-icons">videocam</span>)</span>
                        <?php endif; ?>
                        <div class="input-group-append">
                            <!-- <a data-selector="#field_header_video_<?php echo $i + 1 ?>" class="fb-choose-file btn btn-sm btn-success" href="#">
                                <span class="material-icons">upload</span>
                                <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('file/list', 'Upload a file'); ?>
                            </a> -->
                        </div>
                    </div>
                </div>
            </div>
        <?php endfor; ?>
        <?php foreach ($template['components'] as $component) : ?>
            <?php if ($component['type'] == 'BUTTONS') : ?>
                <?php foreach ($component['buttons'] as $indexButton => $button) : ?>
                    <?php if ($button['type'] == 'MPM') : ?>
                        <div class="col-6">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <button type="button" class="btn btn-add" onclick="addProduct()">Agregar Producto</button>
                                <button type="button" class="btn btn-danger ml-2" onclick="removeProduct()">Eliminar Producto</button>
                            </div>
                            <div id="extraProducts"></div>
                        </div>

                    <?php endif ?>
                <?php endforeach; ?>
            <?php endif ?>
        <?php endforeach ?>
        <?php foreach ($template['components'] as $component) : ?>
            <?php if ($component['type'] == 'BUTTONS') : ?>
                <?php foreach ($component['buttons'] as $indexButton => $button) : ?>
                    <?php if ($button['type'] == 'COPY_CODE') : ?>
                        <div class="col-6">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <label class="font-weight-bold" for="offert_<?php echo $i + 1 ?>">Codigo de oferta</label>
                                <input type="text" class="form-control form-control-sm" id="offert_<?php echo $i + 1 ?>" name="offert">
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <label class="font-weight-bold" for="expiration_offert">Fecha de caducidad</label>
                                <input placeholder="Caducidad" type="date" name="expiration_offert" id="expiration_offert" class="form-control form-control-sm date-input">
                            </div>
                        </div>
                    <?php endif ?>
                <?php endforeach; ?>
            <?php endif ?>
        <?php endforeach ?>

        <?php $tarjeta = 1; ?>
        <?php foreach ($template['components'] as $component) : ?>
            <?php if ($component['type'] == 'CAROUSEL') : ?>
                <?php foreach ($component['cards'] as $card) : ?>
                    <div>
                        <label for="imageCard"><strong>Archivo de tarjeta {{<?php print_r($tarjeta) ?>}}</strong></label>
                        <input type="file" id="imageCard" name="imageCard[]" class="form-control" required onchange="validateFile(this)">
                        <?php $tarjeta++; ?>
                        <?php foreach ($card['components'] as $cardComponent) : ?>
                            <?php if ($cardComponent['format'] == 'VIDEO') : ?>
                                <?php if (in_array('mp4', $allowedExtensions)) : ?>
                                    <span class="file-type-info">(Solo Videos: <span class="material-icons">video_library</span>)</span>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if ($cardComponent['format'] == 'IMAGE') : ?>
                                <?php if (in_array('jpg', $allowedExtensions) && in_array('jpeg', $allowedExtensions) && in_array('png', $allowedExtensions)) : ?>
                                    <span class="file-type-info">(Solo Imágenes: <span class="material-icons">image</span>)</span>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
                <br>
            <?php endif ?>
            <br>
        <?php endforeach; ?>
        <br>

        </div>

        <?php /*<pre><?php echo json_encode($template, JSON_PRETTY_PRINT)?></pre>*/ ?>

        <script>
            function validateFile(input) {
                // Tipos de archivo permitidos obtenidos del PHP
                const allowedExtensions = <?php echo json_encode($allowedExtensions); ?>;

                const file = input.files[0]; // Obtiene el archivo seleccionado
                const fileType = file.type; // Obtiene el tipo MIME del archivo
                const fileName = file.name.toLowerCase(); // Obtiene el nombre del archivo en minúsculas
                const fileExtension = fileName.split('.').pop(); // Obtiene la extensión del archivo

                // Verifica si la extensión del archivo está permitida
                if (!allowedExtensions.includes(fileExtension) || (fileType === 'image/jpeg' && !['jpg', 'jpeg'].includes(fileExtension))) {
                    alert('Por favor, selecciona un archivo compatible con el tipo de encabezado.');
                    input.value = ''; // Limpia el campo de entrada para que el usuario pueda seleccionar otro archivo
                }
            }
        </script>

        <script>
            var productCount = 0; // Inicializamos el contador de productos

            function addProduct() {
                productCount++; // Incrementamos el contador

                // Creamos el nuevo input
                var newInput = document.createElement('div');
                newInput.classList.add('form-group');
                newInput.innerHTML = '<label class="font-weight-bold">Producto ' + productCount + '</label><select class="form-control form-control-sm" name="products[]"><?php foreach ($products as $product) : ?><option value="<?php echo htmlspecialchars($product->code); ?>"><?php echo htmlspecialchars($product->name); ?></option><?php endforeach; ?></select>';


                // Agregamos el nuevo input al contenedor
                document.getElementById('extraProducts').appendChild(newInput);
            }

            function removeProduct() {
                if (productCount > 1) {
                    var lastInput = document.getElementById('extraProducts').lastChild;
                    lastInput.remove(); // Eliminamos el último input
                    productCount--; // Decrementamos el contador
                } else {
                    alert("Se debe ingresar al menos un producto");
                }
            }
        </script>


        <script>
            // Función para mostrar el select al hacer clic en el botón
            function showSelectHeader(fieldId) {
                // Ocultar todos los selects
                var allSelects = document.querySelectorAll('.field-select');
                allSelects.forEach(function(select) {
                    select.style.display = 'none';
                });

                // Mostrar el select correspondiente al botón clicado
                var selectId = 'select_header_' + fieldId;
                var select = document.getElementById(selectId);
                if (select) {
                    select.style.display = 'block';

                    // Limpia las opciones existentes
                    select.innerHTML = '';

                    // Define las opciones deseadas para el encabezado
                    var optionsMap = {
                        'Seleccionar dato': '',
                        'Nombre': '{args.recipient.name_front}',
                        'Apellido': '{args.recipient.lastname_front}',
                        'Empresa': '{args.recipient.company_front}',
                        'Título': '{args.recipient.title_front}',
                        'Email': '{args.recipient.email_front}',
                        'Agregar solo Imágenes JPG': '{args.recipient.file_1_url_front}',
                        'Agregar solo Documentos PDF': '{args.recipient.file_2_url_front}',
                        'Agregar solo Videos MP4': '{args.recipient.file_3_url_front}',
                        'Campo personalizado 1': '{args.recipient.attr_str_1_front}',
                        'Campo personalizado 2': '{args.recipient.attr_str_2_front}',
                        'Campo personalizado 3': '{args.recipient.attr_str_3_front}',
                        'Campo personalizado 4': '{args.recipient.attr_str_4_front}',
                        'Campo personalizado 5': '{args.recipient.attr_str_5_front}',
                        'Campo personalizado 6': '{args.recipient.attr_str_6_front}'
                    };

                    // Agrega las opciones al select
                    for (var optionName in optionsMap) {
                        var optionValue = optionsMap[optionName];

                        var option = document.createElement('option');
                        option.value = optionValue;
                        option.textContent = optionName;
                        select.appendChild(option);
                    }

                    // Agregar evento de cambio al select
                    select.addEventListener('change', function() {
                        var selectedOption = select.options[select.selectedIndex].value;
                        var inputFieldId = 'field_header_doc_' + fieldId; // FIX WITH THIS VARIABLE
                        var inputField = document.getElementById(inputFieldId);
                        if (inputField) {
                            inputField.value = selectedOption;
                        }
                    });
                    select.addEventListener('change', function() {
                        var selectedOption = select.options[select.selectedIndex].value;
                        var inputFieldId = 'field_header_img_' + fieldId; // FIX WITH THIS VARIABLE
                        var inputField = document.getElementById(inputFieldId);
                        if (inputField) {
                            inputField.value = selectedOption;
                        }
                    });
                    select.addEventListener('change', function() {
                        var selectedOption = select.options[select.selectedIndex].value;
                        var inputFieldId = 'field_header_video_' + fieldId; // FIX WITH THIS VARIABLE
                        var inputField = document.getElementById(inputFieldId);
                        if (inputField) {
                            inputField.value = selectedOption;
                        }
                    });
                }
            }
        </script>
        <script>
            // Función para mostrar el select al hacer clic en el botón
            function showSelect(fieldId) {
                // Ocultar todos los selects
                var allSelects = document.querySelectorAll('.field-select');
                allSelects.forEach(function(select) {
                    select.style.display = 'none';
                });

                // Mostrar el select correspondiente al botón clicado
                var selectId = 'select_' + fieldId;
                var select = document.getElementById(selectId);
                if (select) {
                    select.style.display = 'block';

                    // Limpia las opciones existentes
                    select.innerHTML = '';

                    // Define las opciones deseadas
                    var optionsMap = {
                        'Seleccionar dato': '',
                        'Nombre': '{args.recipient.name_front}',
                        'Apellido': '{args.recipient.lastname_front}',
                        'Empresa': '{args.recipient.company_front}',
                        'Título': '{args.recipient.title_front}',
                        'Email': '{args.recipient.email_front}',
                        'Agregar solo Imágenes JPG': '{args.recipient.file_1_url_front}',
                        'Agregar solo Imágenes JPG': '{args.recipient.file_2_url_front}',
                        'Agregar solo Documentos PDF': '{args.recipient.file_3_url_front}',
                        'Agregar solo Videos MP4': '{args.recipient.file_4_url_front}',
                        'Campo personalizado 1': '{args.recipient.attr_str_1_front}',
                        'Campo personalizado 2': '{args.recipient.attr_str_2_front}',
                        'Campo personalizado 3': '{args.recipient.attr_str_3_front}',
                        'Campo personalizado 4': '{args.recipient.attr_str_4_front}',
                        'Campo personalizado 5': '{args.recipient.attr_str_5_front}',
                        'Campo personalizado 6': '{args.recipient.attr_str_6_front}'
                    };


                    // Agrega las opciones al select
                    for (var optionName in optionsMap) {
                        var optionValue = optionsMap[optionName];

                        var option = document.createElement('option');
                        option.value = optionValue;
                        option.textContent = optionName;
                        select.appendChild(option);
                    }

                    // Agregar evento de cambio al select
                    select.addEventListener('change', function() {
                        var selectedOption = select.options[select.selectedIndex].value;
                        var inputFieldId = 'field_' + fieldId;
                        var inputField = document.getElementById(inputFieldId);
                        if (inputField) {
                            inputField.value = selectedOption;
                        }
                    });
                }
            }
        </script>

        <script>
            (function() {


                $('.fb-choose-file').click(function(e) {
                    e.preventDefault(); // Evita que el enlace siga el href

                    // Encuentra el contenedor del campo de entrada relacionado
                    var inputContainer = $(this).closest('.form-group');

                    // Encuentra la entrada de texto dentro del contenedor
                    var inputField = inputContainer.find('input[type="text"]');

                    // Agrega la clase 'embed-into' al campo de entrada
                    inputField.addClass('embed-into');

                    // Abre el modal
                    lhc.revealModal({
                        'iframe': true,
                        'height': 400,
                        'url': '<?php echo erLhcoreClassDesign::baseurl('file/attatchfileimg') ?>'
                    });

                });

            })();
        </script>