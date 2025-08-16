<?php

$tpl = erLhcoreClassTemplate::getInstance('lhfbwhatsappmessaging/statistic_campaign.tpl.php');

$id = $_GET['id'];
$item = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaign::fetch($id);
$instance = LiveHelperChatExtension\fbmessenger\providers\FBMessengerWhatsAppLiveHelperChat::getInstance();
$fbOptions = erLhcoreClassModelChatConfig::fetch('fbmessenger_options');
$data = (array)$fbOptions->data;
$token = $data['whatsapp_access_token'];
$whatsapp_business_account_id = $data['whatsapp_business_account_id'];


$department = erLhcoreClassModelDepartament::fetch($item->dep_id);


$tpl->set('department', $department->name);


$templates = $instance->getTemplates();
$phones = $instance->getPhones();



$messages = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::getList(['filter' => ['campaign_id' => $item->id]]);


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

// Calcular métricas
if (!empty($tiemposLectura)) {
    $promedio = array_sum($tiemposLectura) / count($tiemposLectura);
    $rapida = min($tiemposLectura);
    $lenta = max($tiemposLectura);

    // Día con mayor interacción
    arsort($interaccionesPorDia); // ordenar descendente
    $diaMayor = key($interaccionesPorDia);
    $textoDiaMayor = "{$diaMayor} ({$interaccionesPorDia[$diaMayor]} lecturas)";

    // Día con menor interacción
    asort($interaccionesPorDia); // ordenar ascendente
    $diaMenor = key($interaccionesPorDia);
    $textoDiaMenor = "{$diaMenor} ({$interaccionesPorDia[$diaMenor]} lecturas)";

    // Enviar a la vista
    $tpl->set('promedioLectura', round($promedio, 2));
    $tpl->set('lecturaRapida', $rapida);
    $tpl->set('lecturaLenta', $lenta);
    $tpl->set('diaMayorInteraccion', $textoDiaMayor);
    $tpl->set('diaMenorInteraccion', $textoDiaMenor);
} else {
    $tpl->set('promedioLectura', null);
    $tpl->set('lecturaRapida', null);
    $tpl->set('lecturaLenta', null);
    $tpl->set('diaMayorInteraccion', null);
    $tpl->set('diaMenorInteraccion', null);
}







// print_r('<h1>');
// print_r($messages);
// print_r('</h1>');

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

// Recorremos cada data_point
foreach ($data_x_clicks['data'][0]['data_points'] as $point) {
    if (isset($point['clicked']) && is_array($point['clicked'])) {
        foreach ($point['clicked'] as $click) {
            $boton = $click['button_content'];
            $cantidad = $click['count'];

            // Guardar clicks por botón (sumando si ya existe)
            if (!isset($clicks_por_boton[$boton])) {
                $clicks_por_boton[$boton] = 0;
            }
            $clicks_por_boton[$boton] += $cantidad;

            // Sumar al total
            $total_clicks += $cantidad;
        }
    }
}

$tpl->set('clicksPorBoton', $clicks_por_boton);





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
