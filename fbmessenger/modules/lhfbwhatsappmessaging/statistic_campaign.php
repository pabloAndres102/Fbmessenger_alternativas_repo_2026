<?php

$tpl = erLhcoreClassTemplate::getInstance('lhfbwhatsappmessaging/statistic_campaign.tpl.php');

$id = $_GET['id'];
$item = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaign::fetch($id);
$instance = LiveHelperChatExtension\fbmessenger\providers\FBMessengerWhatsAppLiveHelperChat::getInstance();
$fbOptions = erLhcoreClassModelChatConfig::fetch('fbmessenger_options');
$data = (array)$fbOptions->data;
$token = $data['whatsapp_access_token'];
$whatsapp_business_account_id = $data['whatsapp_business_account_id'];



function fechaAmigable($fecha)
{
    $dias = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
    $meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];

    $timestamp = is_numeric($fecha) ? $fecha : strtotime($fecha); // acepta timestamp o string
    $diaSemana = $dias[date('w', $timestamp)];
    $dia = date('j', $timestamp);
    $mes = $meses[date('n', $timestamp) - 1];
    $hora = date('H:i', $timestamp);

    return ucfirst("$diaSemana $dia de $mes $hora");
}

$department = erLhcoreClassModelDepartament::fetch($item->dep_id);

$tpl->set('department', $department->name);

$templates = $instance->getTemplates();
$phones = $instance->getPhones();

$messages = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::getList([
    'filter' => ['campaign_id' => $item->id]
]);

$tiemposLectura = [];
$interaccionesPorDia = [];

foreach ($messages as $msg) {
    // Solo tomamos los que llegaron a "leído"
    if ($msg->status == 3) {
        $tiempo = $msg->updated_at - $msg->created_at; // Diferencia en segundos
        $tiemposLectura[] = $tiempo;

        // Contar interacciones por día
        $dia = date('Y-m-d', $msg->updated_at);
        if (!isset($interaccionesPorDia[$dia])) {
            $interaccionesPorDia[$dia] = 0;
        }
        $interaccionesPorDia[$dia]++;
    }
}


// Función para formatear tiempo legible
function formatoTiempo($segundos)
{
    $horas = floor($segundos / 3600);
    $minutos = floor(($segundos % 3600) / 60);
    $seg = $segundos % 60;

    $texto = [];
    if ($horas > 0) $texto[] = $horas . "h";
    if ($minutos > 0) $texto[] = $minutos . "m";
    if ($seg > 0 || empty($texto)) $texto[] = $seg . "s";

    return implode(" ", $texto);
}

// Traducciones de días y meses
$dias = ["Sunday" => "Domingo", "Monday" => "Lunes", "Tuesday" => "Martes", "Wednesday" => "Miércoles", "Thursday" => "Jueves", "Friday" => "Viernes", "Saturday" => "Sábado"];
$meses = ["January" => "enero", "February" => "febrero", "March" => "marzo", "April" => "abril", "May" => "mayo", "June" => "junio", "July" => "julio", "August" => "agosto", "September" => "septiembre", "October" => "octubre", "November" => "noviembre", "December" => "diciembre"];

// Función para formatear fecha en español
function fechaEspanol($fecha, $dias, $meses)
{
    $en = date("l, d \d\e F Y", strtotime($fecha));
    $en = strtr($en, $dias);
    $en = strtr($en, $meses);
    return $en;
}

// Calcular métricas
if (!empty($tiemposLectura)) {
    $promedio = array_sum($tiemposLectura) / count($tiemposLectura);
    $rapida = min($tiemposLectura);
    $lenta = max($tiemposLectura);

    // Día con mayor interacción
    arsort($interaccionesPorDia);
    $diaMayor = key($interaccionesPorDia);
    $textoDiaMayor = fechaEspanol($diaMayor, $dias, $meses) . " ({$interaccionesPorDia[$diaMayor]} lecturas)";

    // Día con menor interacción
    asort($interaccionesPorDia);
    $diaMenor = key($interaccionesPorDia);
    $textoDiaMenor = fechaEspanol($diaMenor, $dias, $meses) . " ({$interaccionesPorDia[$diaMenor]} lecturas)";

    // Enviar a la vista
    $tpl->set('promedioLectura', formatoTiempo(round($promedio)));
    $tpl->set('lecturaRapida', formatoTiempo($rapida));
    $tpl->set('lecturaLenta', formatoTiempo($lenta));
    $tpl->set('diaMayorInteraccion', $textoDiaMayor);
    $tpl->set('diaMenorInteraccion', $textoDiaMenor);
} else {
    $tpl->set('promedioLectura', null);
    $tpl->set('lecturaRapida', null);
    $tpl->set('lecturaLenta', null);
    $tpl->set('diaMayorInteraccion', null);
    $tpl->set('diaMenorInteraccion', null);
}



$fechaInicio = $item->starts_at;
$currentTimestamp = $fechaInicio;

// Fecha final: 15 días después
$nextDayTimestamp = $currentTimestamp + (15 * 24 * 60 * 60);

// Conteo de enviados
$sentCount2 = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::getCount([
    'filtergte' => ['created_at' => $currentTimestamp],
    'filterlt'  => ['created_at' => $nextDayTimestamp],
    'filter'    => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_SENT]
]);
$tpl->set('sentCount2', $sentCount2);
// Conteo de entregados
$deliveredCount2 = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::getCount([
    'filtergte' => ['created_at' => $currentTimestamp],
    'filterlt'  => ['created_at' => $nextDayTimestamp],
    'filter'    => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_DELIVERED]
]);
$tpl->set('deliveredCount2', $deliveredCount2);
// Conteo de leídos
$readCount2 = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::getCount([
    'filtergte' => ['created_at' => $currentTimestamp],
    'filterlt'  => ['created_at' => $nextDayTimestamp],
    'filter'    => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_READ]
]);
$tpl->set('readCount2', $readCount2);


$generatedConversations = 0;



foreach ($messages as $message) {
    if ($item->template == $message->template && $messages->chat_id > 0) {
        $generatedConversations = $generatedConversations + 1;
    }
}

$tpl->set('generatedConversations', $generatedConversations);

$template_most = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::getList();

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://graph.facebook.com/v22.0/' . $whatsapp_business_account_id . '/message_templates?name=' . $item->template . '&fields=id%2Cname',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $token
    ),
));

$response = curl_exec($curl);
$response = json_decode($response, true);
$template_id = $response['data'][0]['id'];

curl_close($curl);


$data_x_clicks = $instance->getTemplateMetrics($template_id);

$clicks_por_boton = [];
$total_clicks = 0;


$inicio = $item->starts_at - (1 * 24 * 60 * 60);
$fin = $inicio + (15 * 24 * 60 * 60);

foreach ($data_x_clicks['data'][0]['data_points'] as $point) {
    $start_point = $point['start'];
    $end_point   = $point['end'];

    if ($start_point >= $inicio && $start_point < $fin) {

        if (isset($point['clicked']) && is_array($point['clicked'])) {
            foreach ($point['clicked'] as $click) {
                $boton = $click['button_content'];
                $cantidad = $click['count'];


                if (!isset($clicks_por_boton[$boton])) {
                    $clicks_por_boton[$boton] = 0;
                }
                $clicks_por_boton[$boton] += $cantidad;
                $total_clicks += $cantidad;
            }
        }
    }
}

$tpl->set('clicksPorBoton', $clicks_por_boton);

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://graph.facebook.com/v24.0/' . $whatsapp_business_account_id . '/message_templates?fields=name,language,status,category,id&limit=200&access_token=' . $token,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);

curl_close($curl);

$response = json_decode($response, true);

// 🟩 Buscar la plantilla que coincida con el nombre
$template_id = null;

if (isset($response['data']) && is_array($response['data'])) {
    foreach ($response['data'] as $template) {
        if (isset($template['name']) && $template['name'] === $item->template) {
            $template_id = $template['id'];
            break;
        }
    }
}
    
$tpl->set('template_id', $template_id);




$campaign = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaign::fetch($item->id);

// Decodificar el JSON con las listas asociadas a la campaña
$campaign_ids = json_decode($campaign->lists_id, true);

// Inicializar array de listas asociadas
$listasCampania = [];

if (!empty($campaign_ids) && is_array($campaign_ids)) {

    // Obtener las listas que pertenecen a esta campaña
    $listas = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppContactList::getList([
        'filterin' => ['id' => $campaign_ids]
    ]);

    // Crear un array con los datos relevantes
    foreach ($listas as $lista) {
        $listasCampania[] = [
            'id' => $lista->id,
            'name' => $lista->name
        ];
    }
}

// Enviar al template
$tpl->set('listasCampania', $listasCampania);





if (isset($_POST['email'])) {


    $additionalContent = '
    <li>' . erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Total recipients') . ' - ' . \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['campaign_id' => $item->id]]) . '</li>
    <li>' . erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Pending') . ' - ' . \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_PENDING, 'campaign_id' => $item->id]]) . '</li>
    <li>' . erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'In progress') . ' - ' . \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_IN_PROCESS, 'campaign_id' => $item->id]]) . '</li>
    <li>' . erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Failed') . ' - ' . \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_FAILED, 'campaign_id' => $item->id]]) . '</li>
    <li>' . erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Rejected') . ' - ' . \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_REJECTED, 'campaign_id' => $item->id]]) . '</li>
    <li>' . erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Read') . ' - ' . \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_READ, 'campaign_id' => $item->id]]) . '</li>
    <li>' . erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Scheduled') . ' - ' . \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_SCHEDULED, 'campaign_id' => $item->id]]) . '</li>
    <li>' . erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Delivered') . ' - ' . \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_DELIVERED, 'campaign_id' => $item->id]]) . '</li>
';

    erLhcoreClassChatMail::sendInfoMail($currentUser->getUserData(), $_POST['email'], $additionalContent);

    $_SESSION['email_send_status'] = [
        'type' => 'success',
        'message' => 'El correo se envió correctamente.',
    ];
    header('Location: ' . erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaign'));
}

$item->starts_at = fechaAmigable($item->starts_at);

$tpl->setArray(array(
    'item' => $item,
    'templates' => $templates,
    'phones' => $phones
));

$Result['content'] = $tpl->fetch();


$Result['path'] = array(
    array(
        'url' => erLhcoreClassDesign::baseurl('fbmessenger/index'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Facebook chat'),
    ),
    array(
        'url' => erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaign'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Campaigns')
    ),
    array(
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Statistics')
    )
);
