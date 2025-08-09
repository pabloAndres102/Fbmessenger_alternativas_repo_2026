<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/emojionearea@3.4.2/dist/emojionearea.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/emojionearea@3.4.2/dist/emojionearea.min.js"></script>

<style>
    .whatsapp-buttons {
        display: flex;
        flex-direction: column;
        /* Asegura que los botones se coloquen en una columna */
        gap: 10px;
        /* Espacio entre los botones */
        margin-top: 10px;
    }

    .whatsapp-button-text {
        padding: 10px 15px;
        border-radius: 5px;
        background-color: #25D366;
        /* Color similar al de WhatsApp */
        color: white;
        font-size: 16px;
        text-align: center;
        cursor: pointer;
    }

    .whatsapp-catalog {
        font-size: 16px;
        margin-top: 10px;
    }

    .whatsapp-catalog .material-icons {
        vertical-align: middle;
        font-size: 36px;
        /* Tamaño grande del ícono */
        margin-right: 8px;
    }

    .whatsapp-header .material-icons {
        vertical-align: middle;
        font-size: 50px;
        /* Tamaño grande del ícono */
        margin-right: 8px;
    }

    .whatsapp-button-text,
    .whatsapp-country-code {
        display: inline-block;
        padding: 10px 15px;
        background-color: #25D366;
        /* Color verde de WhatsApp */
        color: white;
        font-weight: bold;
        border-radius: 5px;
        text-align: center;
        text-decoration: none;
        cursor: pointer;
        border: none;
    }

    .whatsapp-button-text {
        display: inline-block;
    }

    /* Ajustes generales para los elementos dentro de la previsualización */
    #previewContainer {
        border: 1px solid #ccc;
        /* Borde alrededor del contenedor de previsualización */
        padding: 10px;
        /* Espaciado interno del contenedor */
        border-radius: 5px;
        /* Bordes redondeados */
        background-color: #f9f9f9;
        /* Color de fondo del contenedor */
    }

    .whatsapp-message {
        max-width: 300px;
        background-color: #DCF8C6;
        /* Color típico del mensaje en WhatsApp */
        border-radius: 10px;
        padding: 10px;
        margin-bottom: 10px;
        box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.15);
        font-family: Arial, sans-serif;
        color: #333;
    }

    .whatsapp-header {
        font-weight: bold;
        margin-bottom: 5px;
        color: #075E54;
        /* Color del texto del encabezado */
    }

    .whatsapp-body {
        margin-bottom: 5px;
    }

    .whatsapp-footer {
        font-size: 12px;
        color: #888;
        text-align: right;
    }

    .variable-group {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .variable-input {
        width: 35%;
        margin-right: 10px;
        /* Espacio entre el input y el icono */
    }

    .eliminarIcon {
        cursor: pointer;
        color: red;
        font-size: 24px;
        vertical-align: middle;
    }


    .button-group {
        margin-bottom: 10px;
    }

    .delete-button {
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
        margin-left: 10px;
    }

    .delete-button:hover .material-icons {
        color: darkred;
    }

    .form-control {
        display: inline-block;
        vertical-align: middle;
    }

    .hidden-content {
        display: none;
    }

    #nombrePaquete {
        display: none;
    }
</style>

<body>
    <!-- <input type="checkbox" id="checkbox"> Ocultar contenido -->
    <div class="container">

        <center>
            <h1><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Create template'); ?></h1>
        </center> <br>
        <center>
            <div id="templatePreview">
            </div>
            <button id="confirmSubmit" style="display:none;" type="submit" class="btn btn-success"><span class="material-icons">send</span><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Create'); ?></button> <br> <br>
        </center>
        <form id="templateForm" method="POST" action=<?php echo erLhcoreClassDesign::baseurl('fbwhatsapp/create') ?> enctype="multipart/form-data" onsubmit="return validateForm()">
            <div class="mb-3">
                <label for="edad" class="form-label"><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('abstract/widgettheme', 'Name'); ?> <?php echo htmlspecialchars($template['name']) ?></strong></label>
                <input type="text" class="form-control" id="templateName" name="templateName" placeholder=<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('abstract/widgettheme', 'Name'); ?> required>
            </div>

            <div class="mb-3">
                <label for="language" class="form-label"> <strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/cannedmsg', 'Language'); ?></strong></label>
                <select class="form-select" id="language" name="language" aria-label="Default select example">
                    <option selected value="es">Español</strong></option>
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
                    <option value="en">Inglés</option>
                    <option value="en_GB">Inglés (Reino Unido)</option>
                    <option value="es_LA">Inglés (EE. UU.)</option>
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
            </div>
            <br>

            <div class="mb-3">
                <label for="templateCat" class="form-label"> <strong>Categoria</strong></label>
                <select class="form-select" id="templateCat" name="templateCat" aria-label="Default select example">
                    <option selected><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('abstract/proactivechatinvitation', 'Category'); ?></strong></option>
                    <option value="MARKETING">Marketing</option>
                    <option value="UTILITY"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Utility'); ?></option>
                    <option value="AUTHENTICATION"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Authentication'); ?></option>
                </select>
            </div>
            <div class="container" id="container">
                <div class="form-check form-switch hidden-content">
                    <label for="buttonCatalog">
                        <input class="form-check-input" type="checkbox" id="buttonCatalog" name="buttonCatalog"> <strong> <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Catalog'); ?> </strong>
                    </label>
                </div>

                <div class="form-check form-switch hidden-content">
                    <label for="buttonMPM">
                        <input class="form-check-input" type="checkbox" id="buttonMPM" name="buttonMPM"> <strong> <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Multi product'); ?> </strong>
                    </label>
                </div>

                <div class="form-check form-switch hidden-content">
                    <label for="offert">
                        <input class="form-check-input" type="checkbox" id="offert" name="offert"> <strong> <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Limited offert'); ?> </strong>
                    </label>
                </div>

                <div class="mb-3 hidden-content" id="headers">
                    <br>
                    <span><small><strong>Ejemplos de contenido del encabezado y variables: </strong><br>
                            Para ayudarnos a revisar tu contenido, proporciona ejemplos de las variables o del contenido multimedia en el encabezado. No incluyas información del cliente. Meta revisa las plantillas y los parámetros de las variables para proteger la seguridad e integridad de nuestros servicios.
                        </small></span><br><br>
                    <label for="header" class="form-label"> <strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Header type'); ?></strong></label>
                    <select class="form-select" id="header" name="header" aria-label="Default select example">
                        <option value=""><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Without header'); ?></option>
                        <option value="DOCUMENT"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Document'); ?></option>
                        <option value="TEXT"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Text'); ?></option>
                        <option value="VIDEO"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Video'); ?></option>
                        <option value="IMAGE"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Image'); ?></option>
                    </select>

                    <label for="campoDeTexto" id="labelCampoDeTexto" class="form-label" hidden> <strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Text header'); ?></strong> </label>
                    <input type="text" id="campoDeTexto" name="campoDeTexto" class="form-control" maxlength="60" placeholder="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'You can upload a variable'); ?>" hidden>
                    <div id="charCount1" class="form-text" hidden>Caracteres: 0 de 60</div>

                    <div id="nuevoInput" style="display: none;">
                        <label for="inputNuevo">Variable</label>
                        <input type="text" id="inputNuevo" name="inputNuevo" class="form-control">
                    </div>

                    <input type="file" name="archivo" id="archivo" class="form-control" hidden>
                </div>

                <div class="form-group shadow-textarea hidden-content">
                    <label for="textAreaTexto"><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Body'); ?></strong></label>
                    <textarea id="textAreaTexto" name="text" class="form-control z-depth-1" rows="3" maxlength="1024" placeholder="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Remember that you can load a maximum of 5 variables'); ?>"></textarea>

                    <button type="button" id="mostrarVariablesBtn" class="btn btn-primary">
                        <span class="material-icons">visibility</span>
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Add variable'); ?>
                    </button>
                    <br>

                    <div id="variableCuerpo" class="variable-group" style="display: none;">
                        <label for="variableCuerpoInput">Variable 1: </label>
                        <input type="text" id="variableCuerpoInput" name="variableCuerpo" class="form-control variable-input" />
                        <span class="material-icons eliminarIcon">delete</span>
                    </div>

                    <div id="variableCuerpo2" class="variable-group" style="display: none;">
                        <label for="variableCuerpoInput2">Variable 2: </label>
                        <input type="text" id="variableCuerpoInput2" name="variableCuerpo2" class="form-control variable-input" />
                        <span class="material-icons eliminarIcon">delete</span>
                    </div>

                    <div id="variableCuerpo3" class="variable-group" style="display: none;">
                        <label for="variableCuerpoInput3">Variable 3: </label>
                        <input type="text" id="variableCuerpoInput3" name="variableCuerpo3" class="form-control variable-input" />
                        <span class="material-icons eliminarIcon">delete</span>
                    </div>

                    <div id="variableCuerpo4" class="variable-group" style="display: none;">
                        <label for="variableCuerpoInput4">Variable 4: </label>
                        <input type="text" id="variableCuerpoInput4" name="variableCuerpo4" class="form-control variable-input" />
                        <span class="material-icons eliminarIcon">delete</span>
                    </div>

                    <div id="variableCuerpo5" class="variable-group" style="display: none;">
                        <label for="variableCuerpoInput5">Variable 5: </label>
                        <input type="text" id="variableCuerpoInput5" name="variableCuerpo5" class="form-control variable-input" />
                        <span class="material-icons eliminarIcon">delete</span>
                    </div>
                </div>



                <label style="display: none;" for="buttonOffertURL"><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'URL site'); ?></strong></strong></label>
                <input class="form-control" type="text" id="buttonNameOffertURL" name="buttonNameOffertURL" maxlength="25" placeholder="Nombre del boton" style="display: none;">
                <input class="form-control" type="url" id="buttonOffertURL" name="buttonOffertURL" maxlength="2000" placeholder="https://www.google.com/" style="display: none;">

                <br>
                <div class="mb-3 hidden-content">
                    <label for="footer" class="form-label"><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Footer'); ?></strong></label>
                    <input type="text" class="form-control" id="footer" name="footer" maxlength="60">
                    <div id="charCount2" class="form-text">Caracteres: 0 de 60</div>
                </div>

                <div class="form-check form-switch hidden-content">
                    <label for="mostrarInputs">
                        <input class="form-check-input" type="checkbox" id="mostrarInputs"> <strong> <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Add button (Quick Reply)'); ?> </strong>
                    </label>
                </div>


                <div id="inputsContainer" style="display: none;">
                    <button type="button" class="btn btn-success" id="addButton" class="styled-button">
                        <span class="material-icons">add</span>&nbsp;
                        Agregar botón
                    </button>
                    <div id="buttonsContainer"></div>
                </div>

                <br>
                <div class="form-check form-switch hidden-content">
                    <label for="mostrarInputsURL">
                        <input class="form-check-input" type="checkbox" id="mostrarInputsURL">
                        <strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Add button (URL)'); ?></strong>
                    </label>
                </div>
                <div id="urlButtonsContainer" style="display: none;">
                    <!-- Aquí se agregarán dinámicamente los campos de texto y URL para los botones de URL -->
                    <button type="button" id="addUrlButton" class="btn btn-primary" style="display: none;">
                        <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Agregar botón URL'); ?>
                    </button>
                </div>
                <br>
                <div class="form-check form-switch hidden-content">
                    <label for="mostrarInputscallback">
                        <input class="form-check-input" type="checkbox" id="mostrarInputscallback"> <strong> <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Add button (Callback)'); ?> </strong>
                    </label>
                </div>
                <div id="inputsContainercallback" style="display: none;">
                    <label for="input1"><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Texto del boton'); ?></strong></label>
                    <input class="form-control" type="text" id="buttonCallbackText" name="buttonCallbackText" maxlength="25">
                    <label for="input2"><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Country code'); ?></strong></label>
                    <select class="form-select" id="buttoCallbackCountry" name="buttoCallbackCountry" aria-label="Default select example">
                        <option selected></option>
                        <option value="93">Afghanistan (93)</option>
                        <option value="358">Åland Islands (358)</option>
                        <option value="355">Albania (355)</option>
                        <option value="213">Algeria (213)</option>
                        <option value="1">American Samoa (1)</option>
                        <option value="376">Andorra (376)</option>
                        <option value="244">Angola (244)</option>
                        <option value="1">Anguilla (1)</option>
                        <option value="672">Antarctica (672)</option>
                        <option value="1">Antigua and Barbuda (1)</option>
                        <option value="54">Argentina (54)</option>
                        <option value="374">Armenia (374)</option>
                        <option value="297">Aruba (297)</option>
                        <option value="61">Australia (61)</option>
                        <option value="43">Austria (43)</option>
                        <option value="994">Azerbaijan (994)</option>
                        <option value="1">Bahamas (1)</option>
                        <option value="973">Bahrain (973)</option>
                        <option value="880">Bangladesh (880)</option>
                        <option value="1">Barbados (1)</option>
                        <option value="375">Belarus (375)</option>
                        <option value="32">Belgium (32)</option>
                        <option value="501">Belize (501)</option>
                        <option value="229">Benin (229)</option>
                        <option value="1">Bermuda (1)</option>
                        <option value="975">Bhutan (975)</option>
                        <option value="591">Bolivia (Plurinational State of) (591)</option>
                        <option value="599">Bonaire, Sint Eustatius and Saba (599)</option>
                        <option value="387">Bosnia and Herzegovina (387)</option>
                        <option value="267">Botswana (267)</option>
                        <option value="47">Bouvet Island (47)</option>
                        <option value="55">Brazil (55)</option>
                        <option value="246">British Indian Ocean Territory (246)</option>
                        <option value="246">United States Minor Outlying Islands (246)</option>
                        <option value="1">Virgin Islands (British) (1)</option>
                        <option value="1 340">Virgin Islands (U.S.) (1 340)</option>
                        <option value="673">Brunei Darussalam (673)</option>
                        <option value="359">Bulgaria (359)</option>
                        <option value="226">Burkina Faso (226)</option>
                        <option value="257">Burundi (257)</option>
                        <option value="855">Cambodia (855)</option>
                        <option value="237">Cameroon (237)</option>
                        <option value="1">Canada (1)</option>
                        <option value="238">Cabo Verde (238)</option>
                        <option value="1">Cayman Islands (1)</option>
                        <option value="236">Central African Republic (236)</option>
                        <option value="235">Chad (235)</option>
                        <option value="56">Chile (56)</option>
                        <option value="86">China (86)</option>
                        <option value="61">Christmas Island (61)</option>
                        <option value="61">Cocos (Keeling) Islands (61)</option>
                        <option value="57">Colombia (57)</option>
                        <option value="269">Comoros (269)</option>
                        <option value="242">Congo (242)</option>
                        <option value="243">Congo (Democratic Republic of the) (243)</option>
                        <option value="682">Cook Islands (682)</option>
                        <option value="506">Costa Rica (506)</option>
                        <option value="385">Croatia (385)</option>
                        <option value="53">Cuba (53)</option>
                        <option value="599">Curaçao (599)</option>
                        <option value="357">Cyprus (357)</option>
                        <option value="420">Czech Republic (420)</option>
                        <option value="45">Denmark (45)</option>
                        <option value="253">Djibouti (253)</option>
                        <option value="1">Dominica (1)</option>
                        <option value="1">Dominican Republic (1)</option>
                        <option value="593">Ecuador (593)</option>
                        <option value="20">Egypt (20)</option>
                        <option value="503">El Salvador (503)</option>
                        <option value="240">Equatorial Guinea (240)</option>
                        <option value="291">Eritrea (291)</option>
                        <option value="372">Estonia (372)</option>
                        <option value="251">Ethiopia (251)</option>
                        <option value="500">Falkland Islands (Malvinas) (500)</option>
                        <option value="298">Faroe Islands (298)</option>
                        <option value="679">Fiji (679)</option>
                        <option value="358">Finland (358)</option>
                        <option value="33">France (33)</option>
                        <option value="594">French Guiana (594)</option>
                        <option value="689">French Polynesia (689)</option>
                        <option value="262">French Southern Territories (262)</option>
                        <option value="241">Gabon (241)</option>
                        <option value="220">Gambia (220)</option>
                        <option value="995">Georgia (995)</option>
                        <option value="49">Germany (49)</option>
                        <option value="233">Ghana (233)</option>
                        <option value="350">Gibraltar (350)</option>
                        <option value="30">Greece (30)</option>
                        <option value="299">Greenland (299)</option>
                        <option value="1">Grenada (1)</option>
                        <option value="590">Guadeloupe (590)</option>
                        <option value="1">Guam (1)</option>
                        <option value="502">Guatemala (502)</option>
                        <option value="44">Guernsey (44)</option>
                        <option value="224">Guinea (224)</option>
                        <option value="245">Guinea-Bissau (245)</option>
                        <option value="592">Guyana (592)</option>
                        <option value="509">Haiti (509)</option>
                        <option value="672">Heard Island and McDonald Islands (672)</option>
                        <option value="379">Vatican City (379)</option>
                        <option value="504">Honduras (504)</option>
                        <option value="36">Hungary (36)</option>
                        <option value="852">Hong Kong (852)</option>
                        <option value="354">Iceland (354)</option>
                        <option value="91">India (91)</option>
                        <option value="62">Indonesia (62)</option>
                        <option value="225">Ivory Coast (225)</option>
                        <option value="98">Iran (Islamic Republic of) (98)</option>
                        <option value="964">Iraq (964)</option>
                        <option value="353">Ireland (353)</option>
                        <option value="44">Isle of Man (44)</option>
                        <option value="972">Israel (972)</option>
                        <option value="39">Italy (39)</option>
                        <option value="1">Jamaica (1)</option>
                        <option value="81">Japan (81)</option>
                        <option value="44">Jersey (44)</option>
                        <option value="962">Jordan (962)</option>
                        <option value="76">Kazakhstan (76)</option>
                        <option value="254">Kenya (254)</option>
                        <option value="686">Kiribati (686)</option>
                        <option value="965">Kuwait (965)</option>
                        <option value="996">Kyrgyzstan (996)</option>
                        <option value="856">Lao People's Democratic Republic (856)</option>
                        <option value="371">Latvia (371)</option>
                        <option value="961">Lebanon (961)</option>
                        <option value="266">Lesotho (266)</option>
                        <option value="231">Liberia (231)</option>
                        <option value="218">Libya (218)</option>
                        <option value="423">Liechtenstein (423)</option>
                        <option value="370">Lithuania (370)</option>
                        <option value="352">Luxembourg (352)</option>
                        <option value="853">Macao (853)</option>
                        <option value="389">North Macedonia (389)</option>
                        <option value="261">Madagascar (261)</option>
                        <option value="265">Malawi (265)</option>
                        <option value="60">Malaysia (60)</option>
                        <option value="960">Maldives (960)</option>
                        <option value="223">Mali (223)</option>
                        <option value="356">Malta (356)</option>
                        <option value="692">Marshall Islands (692)</option>
                        <option value="596">Martinique (596)</option>
                        <option value="222">Mauritania (222)</option>
                        <option value="230">Mauritius (230)</option>
                        <option value="262">Mayotte (262)</option>
                        <option value="52">Mexico (52)</option>
                        <option value="691">Micronesia (Federated States of) (691)</option>
                        <option value="373">Moldova (Republic of) (373)</option>
                        <option value="377">Monaco (377)</option>
                        <option value="976">Mongolia (976)</option>
                        <option value="382">Montenegro (382)</option>
                        <option value="1">Montserrat (1)</option>
                        <option value="212">Morocco (212)</option>
                        <option value="258">Mozambique (258)</option>
                        <option value="95">Myanmar (95)</option>
                        <option value="264">Namibia (264)</option>
                        <option value="674">Nauru (674)</option>
                        <option value="977">Nepal (977)</option>
                        <option value="31">Netherlands (31)</option>
                        <option value="687">New Caledonia (687)</option>
                        <option value="64">New Zealand (64)</option>
                        <option value="505">Nicaragua (505)</option>
                        <option value="227">Niger (227)</option>
                        <option value="234">Nigeria (234)</option>
                        <option value="683">Niue (683)</option>
                        <option value="672">Norfolk Island (672)</option>
                        <option value="850">Korea (Democratic People's Republic of) (850)</option>
                        <option value="1">Northern Mariana Islands (1)</option>
                        <option value="47">Norway (47)</option>
                        <option value="968">Oman (968)</option>
                        <option value="92">Pakistan (92)</option>
                        <option value="680">Palau (680)</option>
                        <option value="970">Palestine, State of (970)</option>
                        <option value="507">Panama (507)</option>
                        <option value="675">Papua New Guinea (675)</option>
                        <option value="595">Paraguay (595)</option>
                        <option value="51">Peru (51)</option>
                        <option value="63">Philippines (63)</option>
                        <option value="64">Pitcairn (64)</option>
                        <option value="48">Poland (48)</option>
                        <option value="351">Portugal (351)</option>
                        <option value="1">Puerto Rico (1)</option>
                        <option value="974">Qatar (974)</option>
                        <option value="383">Republic of Kosovo (383)</option>
                        <option value="262">Réunion (262)</option>
                        <option value="40">Romania (40)</option>
                        <option value="7">Russian Federation (7)</option>
                        <option value="250">Rwanda (250)</option>
                        <option value="590">Saint Barthélemy (590)</option>
                        <option value="290">Saint Helena, Ascension and Tristan da Cunha (290)</option>
                        <option value="1">Saint Kitts and Nevis (1)</option>
                        <option value="1">Saint Lucia (1)</option>
                        <option value="590">Saint Martin (French part) (590)</option>
                        <option value="508">Saint Pierre and Miquelon (508)</option>
                        <option value="1">Saint Vincent and the Grenadines (1)</option>
                        <option value="685">Samoa (685)</option>
                        <option value="378">San Marino (378)</option>
                        <option value="239">Sao Tome and Principe (239)</option>
                        <option value="966">Saudi Arabia (966)</option>
                        <option value="221">Senegal (221)</option>
                        <option value="381">Serbia (381)</option>
                        <option value="248">Seychelles (248)</option>
                        <option value="232">Sierra Leone (232)</option>
                        <option value="65">Singapore (65)</option>
                        <option value="1">Sint Maarten (Dutch part) (1)</option>
                        <option value="421">Slovakia (421)</option>
                        <option value="386">Slovenia (386)</option>
                        <option value="677">Solomon Islands (677)</option>
                        <option value="252">Somalia (252)</option>
                        <option value="27">South Africa (27)</option>
                        <option value="500">South Georgia and the South Sandwich Islands (500)</option>
                        <option value="82">Korea (Republic of) (82)</option>
                        <option value="34">Spain (34)</option>
                        <option value="94">Sri Lanka (94)</option>
                        <option value="249">Sudan (249)</option>
                        <option value="211">South Sudan (211)</option>
                        <option value="597">Suriname (597)</option>
                        <option value="47">Svalbard and Jan Mayen (47)</option>
                        <option value="268">Swaziland (268)</option>
                        <option value="46">Sweden (46)</option>
                        <option value="41">Switzerland (41)</option>
                        <option value="963">Syrian Arab Republic (963)</option>
                        <option value="886">Taiwan (886)</option>
                        <option value="992">Tajikistan (992)</option>
                        <option value="255">Tanzania, United Republic of (255)</option>
                        <option value="66">Thailand (66)</option>
                        <option value="670">Timor-Leste (670)</option>
                        <option value="228">Togo (228)</option>
                        <option value="690">Tokelau (690)</option>
                        <option value="676">Tonga (676)</option>
                        <option value="1">Trinidad and Tobago (1)</option>
                        <option value="216">Tunisia (216)</option>
                        <option value="90">Turkey (90)</option>
                        <option value="993">Turkmenistan (993)</option>
                        <option value="1">Turks and Caicos Islands (1)</option>
                        <option value="688">Tuvalu (688)</option>
                        <option value="256">Uganda (256)</option>
                        <option value="380">Ukraine (380)</option>
                        <option value="971">United Arab Emirates (971)</option>
                        <option value="44">United Kingdom of Great Britain and Northern Ireland (44)</option>
                        <option value="1">United States of America (1)</option>
                        <option value="598">Uruguay (598)</option>
                        <option value="998">Uzbekistan (998)</option>
                        <option value="678">Vanuatu (678)</option>
                        <option value="58">Venezuela (Bolivarian Republic of) (58)</option>
                        <option value="84">Vietnam (84)</option>
                        <option value="681">Wallis and Futuna (681)</option>
                        <option value="212">Western Sahara (212)</option>
                        <option value="967">Yemen (967)</option>
                        <option value="260">Zambia (260)</option>
                        <option value="263">Zimbabwe (263)</option>
                    </select>
                    <label for="input3"><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Phone number'); ?></strong></label>
                    <input class="form-control" type="number" id="buttonCallbackPhone" name="buttonCallbackPhone" maxlength="20"> <br>
                </div>


                <!-- <div class="form-check form-switch hidden-content">
                <label for="mostrarInputsflow">
                    <input class="form-check-input" type="checkbox" id="mostrarInputsflow"> <strong> <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Add button (Flow)'); ?> </strong>
                </label>
            </div>

            <div id="inputsFlowButtons" style="display: none;">
                <label for="text">Text</label>
                <input type="text" class="form-control" name="flow_text" id="flow_text" maxlength="25">
                <label for="flow_id">Flow ID</label>
                <input type="text" class="form-control" name="flow_id" id="flow_id">
                <label for="flow_action">Flow action</label>
                <select class="form-control" name="flow_action" id="flow_action">
                    <option value="navigate">Navigate</option>
                    <option value="data_exchange">Data Exchange</option>
                </select>
                <label for="navigate_screen">Navigate screen</label>
                <input type="text" class="form-control" name="navigate_screen" id="navigate_screen" placeholder="The identifier of the first page of your form">
                <br><br>
            </div> -->


                <div class="authentication-div">

                    <div class="form-check form-switch">
                        <div class="mb-3">
                            <label for="" class="form-label"> <strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'OTP type'); ?></strong></label>
                            <select class="form-select" id="otp_type" name="otp_type" aria-label="Default select example">
                                <option selected></option>
                                <option value="ONE_TAP"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Autofill'); ?></option>
                                <option value="COPY_CODE"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Copy code'); ?></option>
                            </select>
                        </div>

                        <div id="nombrePaquete">
                            <input type="text" class="form-control" id="Nombrepaquete" name="Nombrepaquete" placeholder="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Package name'); ?>">
                            <input type="text" class="form-control" id="Hashpaquete" name="Hashpaquete" placeholder="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Package hash'); ?>">
                            <label for=""><strong> <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Button autofill'); ?> </strong></label>
                            <input type="text" class="form-control" id="buttonAutocompletar" name="buttonAutocompletar" placeholder="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Autofill'); ?>">
                        </div>
                        <div id="caducidad">
                            <label for="caducidad"><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Add the expiration date for the code'); ?></strong>: (Minutos)</label>
                            <input type="number" class="form-control" id="caducidad" name="caducidad" placeholder="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Enter a value between 1 and 90'); ?>" max="90">
                        </div>
                    </div>
                </div>
                <button class="btn btn-success" type="submit">Previsualización<span class="material-icons">visibility</span></button><br>
        </form>


        <br>
        <br> <br> <br> <br> <br> <br> <br> <br> <br>
    </div>
    <script>
        document.getElementById('header').addEventListener('change', function() {
            var archivoInput = document.getElementById('archivo');
            var headerValue = this.value;

            archivoInput.value = ''; // Clear the file input
            archivoInput.hidden = false; // Show the file input

            if (headerValue === 'VIDEO') {
                archivoInput.accept = 'video/*';
            } else if (headerValue === 'IMAGE') {
                archivoInput.accept = 'image/*';
            } else if (headerValue === 'DOCUMENT') {
                archivoInput.accept = 'application/pdf, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, .doc, .docx, .pdf';
            } else if (headerValue === 'TEXT') {
                archivoInput.hidden = true; // Hide the file input for text header
            } else {
                archivoInput.hidden = true; // Hide the file input if no valid header type is selected
            }

            // Show or hide text input based on header type
            var textInput = document.getElementById('campoDeTexto');
            var textLabel = document.getElementById('labelCampoDeTexto');
            var charCount = document.getElementById('charCount1');

            if (headerValue === 'TEXT') {
                textInput.hidden = false;
                textLabel.hidden = false;
                charCount.hidden = false;
            } else {
                textInput.hidden = true;
                textLabel.hidden = true;
                charCount.hidden = true;
            }
        });
    </script>
    <script>
        document.getElementById('mostrarInputsURL').addEventListener('change', function() {
            const urlButtonsContainer = document.getElementById('urlButtonsContainer');
            const addUrlButton = document.getElementById('addUrlButton');

            if (this.checked) {
                urlButtonsContainer.style.display = 'block';
                addUrlButton.style.display = 'block';
            } else {
                urlButtonsContainer.style.display = 'none';
                addUrlButton.style.display = 'none';
            }
        });
    </script>

    <script>
        let urlButtonCount = 0;

        document.getElementById('addUrlButton').addEventListener('click', function() {
            if (urlButtonCount < 2) {
                urlButtonCount++;
                const container = document.getElementById('urlButtonsContainer');
                const buttonTextId = `buttonWebText${urlButtonCount}`;
                const buttonUrlId = `buttonWebUrl${urlButtonCount}`;
                const buttonDivId = `urlButtonDiv${urlButtonCount}`;

                const div = document.createElement('div');
                div.id = buttonDivId;
                div.innerHTML = `
        <h5><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Go to website'); ?></strong></h5>
        <label for="${buttonTextId}"><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Text'); ?></strong></label>
        <input class="form-control" type="text" id="${buttonTextId}" name="${buttonTextId}" maxlength="25">
        <label for="${buttonUrlId}"><strong><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'URL site'); ?></strong></strong></label>
        <input class="form-control" type="url" id="${buttonUrlId}" name="${buttonUrlId}" maxlength="2000" placeholder="https://www.google.com/">
        <button type="button" onclick="removeUrlButton('${buttonDivId}')" class="btn btn-danger">Eliminar</button>
        <hr>
      `;
                container.appendChild(div);
            } else {
                alert("Se pueden agregar un máximo de 2 botones de URL.");
            }
        });

        function removeUrlButton(buttonDivId) {
            const buttonDiv = document.getElementById(buttonDivId);
            if (buttonDiv) {
                buttonDiv.remove();
                urlButtonCount--;
            }
        }
    </script>
    <script>
        let buttonCount = 0;
        const maxButtons = 10;

        document.getElementById('addButton').addEventListener('click', function() {
            if (buttonCount < maxButtons) {
                buttonCount++;
                const buttonsContainer = document.getElementById('buttonsContainer');

                const buttonDiv = document.createElement('div');
                buttonDiv.className = 'button-group';
                buttonDiv.id = `buttonGroup${buttonCount}`;

                const label = document.createElement('label');
                label.setAttribute('for', `button${buttonCount}`);
                label.innerHTML = `<strong>Botón ${buttonCount} (Opcional)</strong>`;

                const input = document.createElement('input');
                input.setAttribute('type', 'text');
                input.setAttribute('class', 'form-control');
                input.setAttribute('id', `button${buttonCount}`);
                input.setAttribute('name', `button${buttonCount}`);
                input.setAttribute('maxlength', '25');
                input.style.width = '30%';

                const deleteButton = document.createElement('button');
                deleteButton.type = 'button';
                deleteButton.className = 'delete-button';
                deleteButton.innerHTML = `<span class="material-icons" style="color: red;">delete</span>`;
                deleteButton.onclick = function() {
                    buttonDiv.remove();
                    buttonCount--;
                };

                buttonDiv.appendChild(label);
                buttonDiv.appendChild(input);
                buttonDiv.appendChild(deleteButton);
                buttonsContainer.appendChild(buttonDiv);
            }
        });
    </script>
    <script>
        function addCharCounter(inputId, counterId, maxLength) {
            const inputField = document.getElementById(inputId);
            const charCounter = document.getElementById(counterId);

            inputField.addEventListener('input', function() {
                const currentLength = inputField.value.length;
                charCounter.textContent = `Caracteres: ${currentLength} de ${maxLength}`;
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            addCharCounter('campoDeTexto', 'charCount1', 60);
            addCharCounter('footer', 'charCount2', 60);
        });
    </script>

    <script>
        document.getElementById('buttonMPM').addEventListener('change', function() {
            var headersDiv = document.getElementById('headers');
            var headerSelect = document.getElementById('header');
            var textHeaderLabel = document.getElementById('labelCampoDeTexto');
            var textField = document.getElementById('campoDeTexto');

            // Siempre mantener el estado del headerSelect cuando el checkbox está desmarcado
            if (!this.checked) {
                headerSelect.value = ''; // Reset header type
                textHeaderLabel.hidden = true;
                textField.hidden = true;
            }

            if (this.checked) {
                headersDiv.style.display = 'block';
                headerSelect.value = 'TEXT'; // Set header type to Text
                headerSelect.disabled = true; // Disable header selection
                textHeaderLabel.hidden = false;
                textField.hidden = false;
            } else {
                headersDiv.style.display = 'none';
                headerSelect.disabled = false; // Enable header selection
            }
        });
    </script>
    <script>
        offert.addEventListener('change', function() {
            const offert = document.getElementById('offert');

            const buttonNameOffertURL = document.getElementById('buttonNameOffertURL');
            const footer = document.getElementById('footer');

            if (offert.checked) {
                footer.style.display = 'none';
                buttonNameOffertURL.style.display = 'block';
                buttonOffertURL.style.display = 'block';

                document.querySelector('label[for="footer"]').style.display = 'none';
                document.querySelector('label[for="buttonNameOffertURL"]').style.display = 'block';
                document.querySelector('label[for="buttonOffertURL"]').style.display = 'block';


            } else {
                buttonNameOffertURL.style.display = 'none';
                buttonOffertURL.style.display = 'none';

                document.querySelector('label[for="buttonNameOffertURL"]').style.display = 'none';
                document.querySelector('label[for="buttonOffertURL"]').style.display = 'none';


            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mostrarInputsCheckbox = document.getElementById('mostrarInputs');
            const mostrarInputscallbackCheckbox = document.getElementById('mostrarInputscallback');
            const mostrarInputsflowCheckbox = document.getElementById('mostrarInputsflow');
            const inputsFlowButtonsDiv = document.getElementById('inputsFlowButtons');
            const buttonOffertURL = document.getElementById('buttonOffertURL');


            const catalog = document.getElementById('buttonCatalog');
            const buttonMPM = document.getElementById('buttonMPM');
            const offert = document.getElementById('offert');
            const headers = document.getElementById('headers');


            catalog.addEventListener('change', function() {
                if (catalog.checked) {
                    offert.style.display = 'none';
                    headers.style.display = 'none';
                    buttonMPM.style.display = 'none';
                    mostrarInputscallbackCheckbox.style.display = 'none';
                    mostrarInputsCheckbox.style.display = 'none';
                    document.querySelector('label[for="offert"]').style.display = 'none';
                    document.querySelector('label[for="buttonMPM"]').style.display = 'none';
                    document.querySelector('label[for="mostrarInputs"]').style.display = 'none';
                    document.querySelector('label[for="mostrarInputscallback"]').style.display = 'none';
                } else {
                    offert.style.display = 'block';
                    headers.style.display = 'block';
                    buttonMPM.style.display = 'block';
                    mostrarInputsCheckbox.style.display = 'block';
                    mostrarInputscallbackCheckbox.style.display = 'block';
                    document.querySelector('label[for="offert"]').style.display = 'block';
                    document.querySelector('label[for="buttonMPM"]').style.display = 'block';
                    document.querySelector('label[for="mostrarInputs"]').style.display = 'block';
                    document.querySelector('label[for="mostrarInputscallback"]').style.display = 'block';
                }
            });
            buttonMPM.addEventListener('change', function() {
                if (buttonMPM.checked) {
                    catalog.style.display = 'none';
                    offert.style.display = 'none';
                    mostrarInputscallbackCheckbox.style.display = 'none';
                    mostrarInputsCheckbox.style.display = 'none';
                    document.querySelector('label[for="buttonCatalog"]').style.display = 'none';
                    document.querySelector('label[for="offert"]').style.display = 'none';
                    document.querySelector('label[for="mostrarInputs"]').style.display = 'none';
                    document.querySelector('label[for="mostrarInputscallback"]').style.display = 'none';
                } else {
                    catalog.style.display = 'block';
                    offert.style.display = 'block';
                    mostrarInputsCheckbox.style.display = 'block';
                    mostrarInputscallbackCheckbox.style.display = 'block';
                    document.querySelector('label[for="offert"]').style.display = 'block';
                    document.querySelector('label[for="buttonCatalog"]').style.display = 'block';
                    document.querySelector('label[for="mostrarInputs"]').style.display = 'block';
                    document.querySelector('label[for="mostrarInputscallback"]').style.display = 'block';
                }
            });

            offert.addEventListener('change', function() {
                if (offert.checked) {
                    buttonOffertURL.style.display = 'block';
                    catalog.style.display = 'none';
                    mostrarInputscallbackCheckbox.style.display = 'none';
                    mostrarInputsCheckbox.style.display = 'none';
                    document.querySelector('label[for="buttonOffertURL"]').style.display = 'block';
                    document.querySelector('label[for="buttonMPM"]').style.display = 'none';
                    document.querySelector('label[for="buttonCatalog"]').style.display = 'none';
                    document.querySelector('label[for="mostrarInputs"]').style.display = 'none';
                    document.querySelector('label[for="mostrarInputscallback"]').style.display = 'none';
                } else {
                    buttonOffertURL.style.display = 'none';
                    catalog.style.display = 'block';
                    offert.style.display = 'block';
                    mostrarInputsCheckbox.style.display = 'block';
                    mostrarInputscallbackCheckbox.style.display = 'block';
                    document.querySelector('label[for="buttonOffertURL"]').style.display = 'none';
                    document.querySelector('label[for="buttonMPM"]').style.display = 'block';
                    document.querySelector('label[for="buttonCatalog"]').style.display = 'block';
                    document.querySelector('label[for="mostrarInputs"]').style.display = 'block';
                    document.querySelector('label[for="mostrarInputscallback"]').style.display = 'block';
                }
            });


            mostrarInputscallbackCheckbox.addEventListener('change', function() {
                if (mostrarInputscallbackCheckbox.checked) {
                    mostrarInputsflowCheckbox.style.display = 'none';
                    document.querySelector('label[for="mostrarInputsflow"]').style.display = 'none';
                    inputsFlowButtonsDiv.style.display = 'none';
                } else {
                    mostrarInputsflowCheckbox.style.display = 'block';
                    document.querySelector('label[for="mostrarInputsflow"]').style.display = 'block';
                }
            });

            mostrarInputsflowCheckbox.addEventListener('change', function() {
                if (mostrarInputsflowCheckbox.checked) {
                    inputsFlowButtonsDiv.style.display = 'block';
                    mostrarInputsCheckbox.style.display = 'none';
                    mostrarInputscallbackCheckbox.style.display = 'none';
                    document.querySelector('label[for="mostrarInputs"]').style.display = 'none';
                    document.querySelector('label[for="mostrarInputscallback"]').style.display = 'none';
                } else {
                    inputsFlowButtonsDiv.style.display = 'none';
                    mostrarInputsCheckbox.style.display = 'block';
                    mostrarInputscallbackCheckbox.style.display = 'block';
                    document.querySelector('label[for="mostrarInputs"]').style.display = 'block';
                    document.querySelector('label[for="mostrarInputscallback"]').style.display = 'block';
                }
            });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mostrarInputsflowCheckbox = document.getElementById('mostrarInputsflow');
            const inputsFlowButtonsDiv = document.getElementById('inputsFlowButtons');

            mostrarInputsflowCheckbox.addEventListener('change', function() {
                if (mostrarInputsflowCheckbox.checked) {
                    inputsFlowButtonsDiv.style.display = 'block';
                } else {
                    inputsFlowButtonsDiv.style.display = 'none';
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            var emojione = $("#textAreaTexto").emojioneArea({
                pickerPosition: "bottom"
            });

            $('#mostrarVariablesBtn').on('click', function() {
                var textArea = emojione[0].emojioneArea;
                var variableCuerpo = $("#variableCuerpo");
                var variableCuerpo2 = $("#variableCuerpo2");
                var variableCuerpo3 = $("#variableCuerpo3");
                var variableCuerpo4 = $("#variableCuerpo4");
                var variableCuerpo5 = $("#variableCuerpo5");

                // Obtener el número de variables ya presentes en el textarea
                var matches = textArea.getText().match(/{{\d+}}/g) || [];
                var variableNumber = matches.length + 1; // Siguiente número de variable

                // Agregar la variable al textarea
                textArea.setText(textArea.getText() + ' {{' + variableNumber + '}} ');

                // Mostrar el siguiente bloque de variables
                switch (variableNumber) {
                    case 1:
                        variableCuerpo.show();
                        break;
                    case 2:
                        variableCuerpo2.show();
                        break;
                    case 3:
                        variableCuerpo3.show();
                        break;
                    case 4:
                        variableCuerpo4.show();
                        break;
                    case 5:
                        variableCuerpo5.show();
                        break;
                }
            });

            // Evento para eliminar el input correspondiente
            $(document).on('click', '.eliminarIcon', function() {
                var inputDiv = $(this).parent(); // Div padre que contiene el input y el icono
                var textArea = emojione[0].emojioneArea;

                // Ocultar el bloque de variables
                inputDiv.hide();

                // Remover la variable del textarea
                var variableLabel = inputDiv.find('label').text().match(/(\d+)/); // Obtener el número de la variable
                if (variableLabel) {
                    var variableNumber = variableLabel[1];
                    var currentText = textArea.getText();
                    var newText = currentText.replace('{{' + variableNumber + '}}', '');
                    textArea.setText(newText.trim());
                }
            });

            $('#quitarVariablesBtn').on('click', function() {
                var textArea = emojione[0].emojioneArea;
                var variableCuerpo = $("#variableCuerpo");
                var variableCuerpo2 = $("#variableCuerpo2");
                var variableCuerpo3 = $("#variableCuerpo3");
                var variableCuerpo4 = $("#variableCuerpo4");
                var variableCuerpo5 = $("#variableCuerpo5");

                // Limpiar el textarea
                textArea.setText('');

                // Ocultar todos los bloques de variables
                variableCuerpo.hide();
                variableCuerpo2.hide();
                variableCuerpo3.hide();
                variableCuerpo4.hide();
                variableCuerpo5.hide();
            });
        });
    </script>
    <script>
        // Obtén una referencia al checkbox y al campo de entrada
        const checkbox1 = document.getElementById("mostrarInputs");
        const button1Input = document.getElementById("button1");

        // Agrega un evento de escucha al cambio del estado del checkbox
        checkbox1.addEventListener("change", function() {
            // Verifica si el checkbox está marcado
            if (checkbox1.checked) {
                // Establece el atributo "required" en el campo de entrada
                button1Input.setAttribute("required", "");
            } else {
                // Quita el atributo "required" del campo de entrada
                button1Input.removeAttribute("required");
            }
        });
    </script>
    <script>
        const otpSelect = document.getElementById('otp_type');
        const nombrePaqueteDiv = document.getElementById('nombrePaquete');

        otpSelect.addEventListener('change', function() {
            if (this.value === 'ONE_TAP') {
                nombrePaqueteDiv.style.display = 'block';
            } else {
                nombrePaqueteDiv.style.display = 'none';
            }
        });
    </script>

    <script>
        const selectElement = document.getElementById('header');
        const inputElement = document.getElementById('campoDeTexto');
        const labelElement = document.getElementById('labelCampoDeTexto');
        const charcountheader = document.getElementById('charCount1');

        selectElement.addEventListener('change', () => {
            const selectedOption = selectElement.options[selectElement.selectedIndex].value;

            if (selectedOption === 'TEXT') {
                inputElement.removeAttribute('hidden');
                labelElement.removeAttribute('hidden');
                charcountheader.removeAttribute('hidden');
            } else {
                inputElement.setAttribute('hidden', 'true');
                labelElement.setAttribute('hidden', 'true');
                charcountheader.setAttribute('hidden', 'true');
            }

        });

        const checkbox = document.getElementById('mostrarInputs');
        const inputsContainer = document.getElementById('inputsContainer');

        checkbox.addEventListener('change', function() {
            if (checkbox.checked) {
                inputsContainer.style.display = 'block';
            } else {
                inputsContainer.style.display = 'none';
            }
        });


        const checkboxcallback = document.getElementById('mostrarInputscallback');
        const inputsContainercallback = document.getElementById('inputsContainercallback');

        checkboxcallback.addEventListener('change', function() {
            if (checkboxcallback.checked) {
                inputsContainercallback.style.display = 'block';
            } else {
                inputsContainercallback.style.display = 'none';
            }
        });
    </script>
    <script>
        const selectHeader = document.getElementById('header');
        const inputFile = document.getElementById('archivo');
        selectHeader.addEventListener('change', () => {
            const selectedOption = selectHeader.options[selectHeader.selectedIndex].value;
            const isFileOption = ['DOCUMENT', 'IMAGE', 'VIDEO'].includes(selectedOption);
            if (isFileOption) {
                inputFile.removeAttribute('hidden');
            } else {
                inputFile.setAttribute('hidden', 'true');
            }
        });
    </script>
    <script>
        document.getElementById('campoDeTexto').addEventListener('input', function() {

            const textoIngresado = this.value;
            const nuevoInput = document.getElementById('nuevoInput');

            if (textoIngresado.includes("{{1}}")) {
                nuevoInput.style.display = 'block';
            } else {

                nuevoInput.style.display = 'none';
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categoriaSelector = document.getElementById('templateCat');

            const authenticationDiv = document.querySelector('.authentication-div');
            const elementosOcultos = document.querySelectorAll('.hidden-content');

            function toggleContenido() {
                const selectedOption = categoriaSelector.value;
                if (selectedOption === 'MARKETING' || selectedOption === 'UTILITY') {
                    elementosOcultos.forEach(element => {
                        element.style.display = 'block';
                    });
                } else {
                    elementosOcultos.forEach(element => {
                        element.style.display = 'none';
                    });
                }
            }

            function toggleAuthenticationDiv() {
                const selectedOption = categoriaSelector.value;
                if (selectedOption === 'AUTHENTICATION') {
                    authenticationDiv.style.display = 'block';
                } else {
                    authenticationDiv.style.display = 'none';
                }
            }
            categoriaSelector.addEventListener('change', toggleAuthenticationDiv);

            // Llamamos a la función para que se oculte/muestre en la carga inicial
            toggleAuthenticationDiv();

            // Asignamos el evento al selector de categoría
            categoriaSelector.addEventListener('change', toggleContenido);

            // Llamamos a la función para que se oculte/muestre en la carga inicial
            toggleContenido();
        });
    </script>
    <script>
        function validateForm() {
            var inputElement = document.getElementById('buttonWebUrl');
            var url = inputElement.value.trim();
            var checkbox = document.getElementById('mostrarInputscallback');
            var buttonCallbackText = document.getElementById('buttonCallbackText');
            var buttonWebUrl = document.getElementById('buttonWebUrl');

            if (checkbox.checked) {
                // Si el checkbox está marcado, verifica si al menos uno de los campos "Llamada a la acción" o "URL del sitio web" está lleno
                if (buttonCallbackText.value === '' && buttonWebUrl.value === '') {
                    alert('Por favor, complete todos los campos: Llamada a la acción o Ir al sitio web.');
                    return false; // Detiene el envío del formulario
                }
            }
            // Obtiene el valor del campo templateName
            var templateName = document.getElementById('templateName').value;

            // Define una expresión regular para permitir solo letras minúsculas y guiones bajos
            var pattern = /^[a-z0-9_]+$/;

            // Realiza la validación
            if (!pattern.test(templateName)) {
                // El nombre de la plantilla no cumple con los requisitos
                alert("El nombre de la plantilla solo puede contener letras minúsculas y guiones bajos.");
                return false; // Evita que el formulario se envíe
            }

            // Si el nombre de la plantilla es válido, permite que el formulario se envíe
            return true;
        }
    </script>
    <script>
        document.getElementById('templateForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Evita el envío del formulario inicialmente

            let previewContent = '';

            // Evaluar el valor de los campos del formulario

            const category = document.getElementById('templateCat').value;
            const headerType = document.getElementById('header').value;
            const headerText = document.getElementById('campoDeTexto').value;
            const bodyText = document.getElementById('textAreaTexto').value;
            const footerText = document.getElementById('footer').value;
            const buttonText = document.getElementById('buttonCallbackText').value;
            const countryCode = document.getElementById('buttoCallbackCountry').value;
            const buttonCatalogChecked = document.getElementById('buttonCatalog').checked;
            const buttonNameOffertURL = document.getElementById('buttonNameOffertURL').value;
            const buttonOffertURL = document.getElementById('buttonOffertURL').value;

            // Inputs para OTP y otros detalles
            const otpType = document.getElementById('otp_type').value;
            const packageName = document.getElementById('Nombrepaquete').value;
            const packageHash = document.getElementById('Hashpaquete').value;
            const buttonAutocompletar = document.getElementById('buttonAutocompletar').value;
            const expiration = document.getElementById('caducidad').value;

            if (headerType) {
                if (headerType === 'VIDEO') {
                    previewContent += `<div class="whatsapp-header"><span class="material-icons">videocam</span></div>`;
                } else if (headerType === 'IMAGE') {
                    previewContent += `<div class="whatsapp-header"><span class="material-icons">image</span>`;
                } else if (headerType === 'DOCUMENT') {
                    previewContent += `<div class="whatsapp-header"><span class="material-icons">description</span>`;
                } else {
                    previewContent += `<div class="whatsapp-header">${headerText}</div>`;
                }
            }
            if (bodyText) {
                previewContent += `<div class="whatsapp-body">${bodyText}</div>`;
            }
            if (footerText) {
                previewContent += `<div class="whatsapp-footer">${footerText}</div>`;
            }
            if (buttonText) {
                previewContent += `<div class="whatsapp-button-text"> ${buttonText}</div>`;
            }
            if (buttonCatalogChecked) {
                previewContent += `<div class="whatsapp-catalog"><span class="material-icons">shopping_cart</span></div>`;
            }

            for (let i = 1; i <= 2; i++) {
                const buttonTextInput = document.getElementById(`buttonWebText${i}`)?.value;
                const buttonUrlInput = document.getElementById(`buttonWebUrl${i}`)?.value;

                if (buttonTextInput && buttonUrlInput) {
                    previewContent += '<div class="whatsapp-buttons">';
                    previewContent += `
                    <div class="whatsapp-button-text">${buttonTextInput}</div>
                `;
                    previewContent += '</div>';
                }

            }
            const buttonsContainer = document.getElementById('buttonsContainer');
            const buttons = buttonsContainer.getElementsByClassName('button-group');
            if (buttons.length > 0) {
                previewContent += '<div class="whatsapp-buttons">';
                for (let i = 0; i < buttons.length; i++) {
                    const buttonInput = buttons[i].querySelector('input').value;
                    if (buttonInput) {
                        previewContent += `<div class="whatsapp-button-text">${buttonInput}</div>`;
                    }
                }
                previewContent += '</div>';
            }
            if (buttonNameOffertURL && buttonOffertURL) {
                previewContent += '<div class="whatsapp-buttons">';
                previewContent += `
                    <div class="whatsapp-button-text">${buttonNameOffertURL}</div>
                `;
                previewContent += '</div>';
            }
            if (otpType) {
                previewContent += `<div class="whatsapp-otp">
            <div><strong>OTP Type:</strong> ${otpType}</div>`;
                if (otpType === 'ONE_TAP') {
                    previewContent += `<div> ${packageName}</div>`;
                    previewContent += `<div> ${packageHash}</div>`;
                    previewContent += `<div> ${buttonAutocompletar}</div>`;
                }
                previewContent += `<div> ${expiration}</div></div>`;
            }

            // Mostrar la previsualización en un estilo de WhatsApp
            document.getElementById('templatePreview').innerHTML = `<div class="whatsapp-message">${previewContent}</div>`;

            // Mostrar el botón de confirmación para enviar el formulario
            document.getElementById('confirmSubmit').style.display = 'inline-block';
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        document.getElementById('confirmSubmit').addEventListener('click', function() {
            // Enviar el formulario
            document.getElementById('templateForm').submit();
        });
    </script>

</body>