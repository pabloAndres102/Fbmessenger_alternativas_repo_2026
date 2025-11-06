<?php
$tpl = erLhcoreClassTemplate::getInstance('lhfbwhatsapp/templates.tpl.php');
$fbOptions = erLhcoreClassModelChatConfig::fetch('fbmessenger_options');
$data = (array)$fbOptions->data;

try {
    $instance = LiveHelperChatExtension\fbmessenger\providers\FBMessengerWhatsAppLiveHelperChat::getInstance();
    $templates = $instance->getTemplates();
    $dbTemplates = erLhcoreClassModelMessageFBWhatsAppTemplate::getList();

    // Inicializa la variable de conteo de plantillas
    $templateCount = 0;
    $filteredTemplates = [];

    // Mapeo: nombre + idioma => registro en DB
    $mapTemplates = [];
    foreach ($dbTemplates as $dbTemplate) {
        $key = strtolower($dbTemplate->name . '_' . $dbTemplate->language);
        $mapTemplates[$key] = $dbTemplate;
    }

    // Añadir created_at a las plantillas traídas de Meta
    foreach ($templates as &$tplData) {
        $key = strtolower($tplData['name'] . '_' . $tplData['language']);
        if (isset($mapTemplates[$key])) {
            $tplData['created_at'] = $mapTemplates[$key]->created_at;
        } else {
            $tplData['created_at'] = null; // En caso de no estar en BD
        }
    }
    unset($tplData);

    // Filtrado de plantillas basado en parámetros GET
    $searchName = isset($_GET['search_name']) ? trim($_GET['search_name']) : '';
    $searchStatus = isset($_GET['search_status']) ? $_GET['search_status'] : '';
    $searchCategory = isset($_GET['search_category']) ? $_GET['search_category'] : '';
    $searchLanguage = isset($_GET['search_language']) ? $_GET['search_language'] : '';

    $excludedTemplates = array(
        'sample_purchase_feedback',
        'sample_issue_resolution',
        'sample_flight_confirmation',
        'sample_shipping_confirmation',
        'sample_happy_hour_announcement',
        'sample_movie_ticket_confirmation'
    );

    foreach ($templates as $template) {

        // Si está rechazada, consultamos detalles
        if ($template['status'] == 'REJECTED') {
            $access_token = $data['whatsapp_access_token'];

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://graph.facebook.com/v20.0/' . $template['id'] . '?fields=name%2Clanguage%2Cstatus%2Ccategory%2Crejected_reason%2Cquality_score&access_token=' . $access_token,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));
            $response = curl_exec($curl);
            $response = json_decode($response, true);
            curl_close($curl);

            if (!isset($template['rejected_reason'])) {
                $template['rejected_reason'] = array();
            }
            $template['rejected_reason'] = $response['rejected_reason'];
        }

        if (!in_array($template['name'], $excludedTemplates)) {

            // Filtrado por nombre
            if ($searchName && stripos($template['name'], $searchName) === false) {
                continue;
            }
            // Filtrado por estado
            if ($searchStatus && $template['status'] !== $searchStatus) {
                continue;
            }
            // Filtrado por categoría
            if ($searchCategory && $template['category'] !== $searchCategory) {
                continue;
            }
            // Filtrado por idioma
            if ($searchLanguage && $template['language'] !== $searchLanguage) {
                continue;
            }

            // Si pasa los filtros, añádelo
            $filteredTemplates[] = $template;
            $templateCount++;
        }
    }
} catch (Exception $e) {
    if (!$tpl instanceof erLhcoreClassTemplate) {
        $tpl = erLhcoreClassTemplate::getInstance('lhfbwhatsapp/templates.tpl.php');
    }
    $tpl->set('error', $e->getMessage());
    $filteredTemplates = [];
}

// Configuración de permisos
if ($currentUser->hasAccessTo('lhfbwhatsapp', 'delete_templates')) {
    $tpl->set('delete_template', true);
} else {
    $tpl->set('delete_template', false);
}

// Paginación
$pages = new lhPaginator();
$pages->items_total = $templateCount;

// Si hay búsqueda, no se aplica paginación
if ($searchName || $searchStatus || $searchCategory || $searchLanguage) {
    $pages->setItemsPerPage($templateCount); // Muestra todos los resultados
} else {
    $itemsPerPage = 7; // Paginación normal
    $pages->setItemsPerPage($itemsPerPage);
}

$filteredTemplates = array_slice($filteredTemplates, $pages->low, $pages->items_per_page);
$pages->translationContext = 'chat/activechats';
$pages->serverURL = erLhcoreClassDesign::baseurl('fbwhatsapp/templates');
if ($templateCount > 0) {
    $pages->paginate();
} else {
    $pages->items_total = 0;
    $pages->setItemsPerPage(1); // valor dummy
    $pages->low = 0;
    $pages->items_per_page = 0;
}

$tpl->set('pages', $pages);
$tpl->set('templates', $filteredTemplates);

$Result['content'] = $tpl->fetch();
$Result['path'] = array(
    array(
        'url' => erLhcoreClassDesign::baseurl('fbmessenger/index'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Facebook chat')
    ),
    array(
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Templates')
    )
);
