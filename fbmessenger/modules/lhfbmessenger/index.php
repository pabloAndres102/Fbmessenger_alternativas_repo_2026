<?php


$tpl = erLhcoreClassTemplate::getInstance('lhfbmessenger/index.tpl.php');
$fbOptions = erLhcoreClassModelChatConfig::fetch('fbmessenger_options');
$data = (array)$fbOptions->data;
$token = $data['whatsapp_access_token'];
$wbai = $data['whatsapp_business_account_id'];


$instance = \LiveHelperChatExtension\fbmessenger\providers\FBMessengerWhatsAppLiveHelperChat::getInstance();
$templates = $instance->getTemplates();
$excludedTemplates = array(
    'sample_purchase_feedback',
    'sample_issue_resolution',
    'sample_flight_confirmation',
    'sample_shipping_confirmation',
    'sample_happy_hour_announcement',
    'sample_movie_ticket_confirmation'
);
foreach ($excludedTemplates as $excludedTemplate) {
    foreach ($templates as $key => $template) {
        if ($template['name'] === $excludedTemplate) {
            unset($templates[$key]);
        }
    }
}
$templates = array_values($templates);


$array_ids = [];

foreach ($templates as $template) {
    $array_ids[] = $template['id'];
}




if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $startTimestamp = strtotime($_POST['start']);
    $endTimestamp = strtotime($_POST['end']);
    $phone = $_POST['phone'];
    $businessAccount = $_POST['businessAccount'];
} else {
    $startTimestamp = strtotime(date('Y-m-01 00:00:00'));
    $endTimestamp = strtotime(date('Y-m-d H:i:s'));
    $phone = '';
    $businessAccount = '';
}


$tpl->set('startTimestamp', $startTimestamp);
$tpl->set('endTimestamp', $endTimestamp);

$baseFilter = [
    'filtergte' => [
        'created_at' => $startTimestamp
    ],
    'filterlte' => [
        'created_at' => $endTimestamp
    ],
];

if (!empty($phone)) {
    $baseFilter['filterlike'] = [
        'phone' => $phone
    ];
}
if (!empty($businessAccount)) {
    $baseFilter['filter']['business_account_id'] = $businessAccount;
}


$suma = 0;

// Filtro y conteo para mensajes Fallídos
$failedFilter = $baseFilter;
$failedFilter['filter']['status'] = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_FAILED;
$failedCount = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::getCount($failedFilter);
$tpl->set('failedCount', $failedCount);


// Filtro y conteo para mensajes enviados
$sentFilter = $baseFilter;
$sentFilter['filter']['status'] = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_SENT;
$sentCount = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::getCount($sentFilter);
$tpl->set('sentCount', $sentCount);

// Filtro y conteo para mensajes leídos
$readFilter = $baseFilter;
$readFilter['filter']['status'] = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_READ;
$readCount = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::getCount($readFilter);
$tpl->set('readCount', $readCount);

// Filtro y conteo para mensajes pendientes
$pendingFilter = $baseFilter;
$pendingFilter['filter']['status'] = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_PENDING;
$pendingCount = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::getCount($pendingFilter);
$tpl->set('pendingCount', $pendingCount);

// Filtro y conteo para mensajes rechazados
$rejectedFilter = $baseFilter;
$rejectedFilter['filter']['status'] = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_REJECTED;
$rejectedCount = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::getCount($rejectedFilter);
$tpl->set('rejectedCount', $rejectedCount);

// Filtro y conteo para mensajes entregados
$deliveredFilter = $baseFilter;
$deliveredFilter['filter']['status'] = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_DELIVERED;
$deliveredCount = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::getCount($deliveredFilter);
$tpl->set('deliveredCount', $deliveredCount);

$template_most = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::getList($baseFilter);

$templateFrequency = [];

foreach ($template_most as $message) {
    $template = $message->template;
    if (!isset($templateFrequency[$template])) {
        $templateFrequency[$template] = 1;
    } else {
        $templateFrequency[$template]++;
    }
}

$maxFrequency = 0;
$mostRepeatedTemplate = null;

foreach ($templateFrequency as $template => $frequency) {
    if ($frequency > $maxFrequency) {
        $maxFrequency = $frequency;
        $mostRepeatedTemplate = $template;
    }
}
if ($mostRepeatedTemplate !== null) {
    $tpl->set('mostRepeatedTemplate', $mostRepeatedTemplate);
    $tpl->set('maxFrequency', $maxFrequency);
}

$day_most_sent = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::getList($baseFilter);

// Contador de frecuencia de mensajes por día
$messagesPerDay = [];


// Contar la frecuencia de mensajes por día
foreach ($day_most_sent as $day) {
    $createdTimestamp = $day->created_at;
    $dayKey = date('Y-m-d', $createdTimestamp); // Convertir la marca de tiempo a formato de fecha 'Y-m-d'
    if (!isset($messagesPerDay[$dayKey])) {
        $messagesPerDay[$dayKey] = 1;
    } else {
        $messagesPerDay[$dayKey]++;
    }
}

// Encontrar el día con más mensajes enviados
$maxMessages = 0;
$dayWithMostMessages = null;

foreach ($messagesPerDay as $day => $messageCount) {
    if ($messageCount > $maxMessages) {
        $maxMessages = $messageCount;
        $dayWithMostMessages = $day;
    }
}

if ($dayWithMostMessages !== null) {
    $tpl->set('dayWithMostMessages', $dayWithMostMessages);
    $tpl->set('maxMessages', $maxMessages);
}



$chatid = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::getCount(array_merge($baseFilter, [
    'filtergt' => [
        'chat_id' => 0
    ]
]));


$suma = $readCount + $sentCount + $deliveredCount + $failedCount + $rejectedCount;

if ($suma > 0) {
    $engagement = round(($readCount / $suma) * 100, 2);
} else {
    $engagement = 0;
}

$tpl->set('totalSent', $suma);
$tpl->set('totalRead', $readCount);
$tpl->set('engagement', $engagement);
$tpl->set('sentCount', $sentCount);
$tpl->set('chatid', $chatid);

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://graph.facebook.com/v20.0/' . $data['whatsapp_business_account_id'] . '?fields=conversation_analytics.start(' . $startTimestamp . ').end(' . $endTimestamp . ').conversation_categories(SERVICE).granularity(DAILY).dimensions(CONVERSATION_CATEGORY)&limit=1000',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer ' . $token
    ),
));

$response = curl_exec($curl);
curl_close($curl);
$json_response = json_decode($response, true);

$msg_services = 0;

if (isset($json_response['conversation_analytics']['data'][0]['data_points'])) {
    $data_points = $json_response['conversation_analytics']['data'][0]['data_points'];

    foreach ($data_points as $data_point) {
        if (isset($data_point['conversation_category'])) {
            $msg_services = $msg_services + $data_point['conversation'];
        }
    }
}

$tpl->set('msg_services', $msg_services);

//////////////////////////////////////////////

$averageRead = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::getList(array_merge($baseFilter, [
    'filter' => [
        'status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_READ,
    ]
]));


$totalSeconds = 0;
$slowestReadTime = 0;
$fastestReadTime = PHP_INT_MAX;
$slowestReadMessage = null;
$fastestReadMessage = null;
$totalMessages = count($averageRead);

foreach ($averageRead as $message) {
    $createdTimestamp = $message->created_at;
    $updatedTimestamp = $message->updated_at;
    $difference = $updatedTimestamp - $createdTimestamp;

    if ($difference < $fastestReadTime) {
        $fastestReadTime = $difference;
        $fastestReadMessage = $message;
    }
    if ($difference > $slowestReadTime) {
        $slowestReadTime = $difference;
        $slowestReadMessage = $message;
    }

    $totalSeconds += $difference;
}

if ($totalMessages > 0) {
    $averageSeconds = $totalSeconds / $totalMessages;
    $averageHours = floor($averageSeconds / 3600);
    $averageMinutes = floor(($averageSeconds % 3600) / 60);
    $averageSeconds = $averageSeconds % 60;
    $averageTime = "" . $averageHours . ' h ' . $averageMinutes . ' m ' . $averageSeconds . ' s';
    $tpl->set('averageTime', $averageTime);
} else {
    $tpl->set('averageTime', 0);
}

if ($fastestReadMessage !== null) {
    // Calcular el tiempo más rápido en horas, minutos y segundos
    $fastestHours = floor($fastestReadTime / 3600);
    $fastestMinutes = floor(($fastestReadTime % 3600) / 60);
    $fastestSeconds = $fastestReadTime % 60;
    $fastestTime = $fastestHours . ' h ' . $fastestMinutes . ' m ' . $fastestSeconds . ' s';
    $tpl->set('fastestTime', $fastestTime);
    // Ahora $fastestTime contiene el tiempo de lectura más rápido y $fastestReadMessage contiene el mensaje asociado.
}
if ($slowestReadMessage !== null) {
    // Calcular el tiempo más lento en horas, minutos y segundos
    $slowestHours = floor($slowestReadTime / 3600);
    $slowestMinutes = floor(($slowestReadTime % 3600) / 60);
    $slowestSeconds = $slowestReadTime % 60;
    $slowestTime = $slowestHours . ' h ' . $slowestMinutes . ' m ' . $slowestSeconds . ' s';
    $tpl->set('slowestTime', $slowestTime);
    // Ahora $slowestTime contiene el tiempo de lectura más lento y $slowestReadMessage contiene el mensaje asociado.
}
$minEngagement = PHP_INT_MAX;
$dayWithMinEngagement = null;
$maxEngagement = 0;
$dayWithMaxEngagement = null;

for ($day = $startTimestamp; $day <= $endTimestamp; $day += 86400) { // Incrementa en un día (86400 segundos)
    $dayEnd = $day + 86399; // Establece el final del día a las 23:59:59
    $dayreadCount = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::getCount([
        'filtergte' => [
            'created_at' => $day,
        ],
        'filterlte' => [
            'created_at' => $dayEnd,
        ],
        'filter' => [
            'status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_READ,
        ],
    ]);

    $dayTotalMessages = $dayreadCount + $sentCount + $deliveredCount + $failedCount + $rejectedCount;
    if ($dayTotalMessages > 0) {
        $dayEngagement = round(($dayreadCount / $dayTotalMessages) * 100, 2);
    } else {
        $dayEngagement = 0;
    }

    if ($dayEngagement > $maxEngagement) {
        $maxEngagement = $dayEngagement;
        $dayWithMaxEngagement = date('Y-m-d', $day); // Formato de fecha Y-m-d
        $tpl->set('dayWithMaxEngagement', $dayWithMaxEngagement);
    }
    if ($dayEngagement < $minEngagement) {
        $minEngagement = $dayEngagement;
        $dayWithMinEngagement = date('Y-m-d', $day); // Formato de fecha Y-m-d
        $tpl->set('dayWithMinEngagement', $dayWithMinEngagement);
    }
}

////////////////////////////////////////////////////////////////////////////////

$agents = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::getList([
    'filtergte' => [
        'created_at' => $startTimestamp
    ],
    'filterlt' => [
        'created_at' => $endTimestamp
    ]
]);









////////////////////////////////////////////////////////////////
$agentArray = [];
$sentPerDay = [];
$readPerDay = [];
$messagesByAgent = [];
$generatedConversationPerDay = [];

// Configuración de fechas
$currentTimestamp = $startTimestamp;
$endTimestamp = time(); // Esto debería ser el final de tu período de tiempo

// Iterar mientras el tiempo actual sea menor o igual al tiempo final
while ($currentTimestamp <= $endTimestamp) {
    $nextDayTimestamp = strtotime('+1 day', $currentTimestamp);

    // Obtener la cantidad de mensajes enviados por día
    $sentCount = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::getCount([
        'filtergte' => [
            'created_at' => $currentTimestamp
        ],
        'filterlt' => [
            'created_at' => $nextDayTimestamp
        ],
        'filter' => [
            'status' => [
                \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_READ,
                \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_SENT,
                \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_FAILED,
                \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_DELIVERED,
                \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_REJECTED,
            ]
        ]
    ]);

    $agents = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::getList([
        'filtergte' => [
            'created_at' => $currentTimestamp
        ],
        'filterlt' => [
            'created_at' => $nextDayTimestamp
        ]
    ]);


    
    foreach ($agents as $agent) {
        $username = $agent->user->username;
        if (!isset($messagesByAgent[$username])) {
            $messagesByAgent[$username] = 1;
        } else {
            $messagesByAgent[$username]++;
        }
    }
 






    $sentPerDay[] = $sentCount;
    $tpl->set('sentPerDay', $sentPerDay);
    // Obtener los mensajes enviados por día

    // Obtener la cantidad de mensajes leídos por día
    $readCount2 = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::getCount([
        'filtergte' => [
            'created_at' => $currentTimestamp
        ],
        'filterlt' => [
            'created_at' => $nextDayTimestamp
        ],
        'filter' => [
            'status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_READ,
        ]
    ]);
    $readPerDay[] = $readCount2;
    $tpl->set('readPerDay', $readPerDay);

    $deliveredCount2 = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::getCount([
        'filtergte' => [
            'created_at' => $currentTimestamp
        ],
        'filterlt' => [
            'created_at' => $nextDayTimestamp
        ],
        'filter' => [
            'status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_DELIVERED,
        ]
    ]);

    $failedCount2 = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::getCount([
        'filtergte' => [
            'created_at' => $currentTimestamp
        ],
        'filterlt' => [
            'created_at' => $nextDayTimestamp
        ],
        'filter' => [
            'status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_FAILED,
        ]
    ]);

    $rejectedCount2 = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::getCount([
        'filtergte' => [
            'created_at' => $currentTimestamp
        ],
        'filterlt' => [
            'created_at' => $nextDayTimestamp
        ],
        'filter' => [
            'status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_REJECTED,
        ]
    ]);
    $sentCount2 = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::getCount([
        'filtergte' => [
            'created_at' => $currentTimestamp
        ],
        'filterlt' => [
            'created_at' => $nextDayTimestamp
        ],
        'filter' => [
            'status' => \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_SENT,
        ]
    ]);

    $dailyTotalMessages = $sentCount2 + $deliveredCount2 + $failedCount2 + $rejectedCount2 + $readCount2;


    if ($dailyTotalMessages > 0) {
        $dailyEngagement = round(($readCount2 / $dailyTotalMessages) * 100, 2); // Calcular el engagement
    } else {
        $dailyEngagement = 0;
    }

    $engagementPerDay[date('Y-m-d', $currentTimestamp)] = $dailyEngagement;

    $tpl->set('engagementDates', array_keys($engagementPerDay));
    $tpl->set('engagementValues', array_values($engagementPerDay));


    $generatedConversation = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::getCount([
        'filtergt' => [
            'chat_id' => 0
        ],
        'filtergte' => [
            'created_at' => $currentTimestamp
        ],
        'filterlte' => [
            'created_at ' => $nextDayTimestamp
        ]
    ]);

    $generatedConversationPerDay[] = $generatedConversation;
    $tpl->set('generatedConversationPerDay', $generatedConversationPerDay);

    $currentTimestamp = $nextDayTimestamp;
}

$tpl->set('agentNames', array_keys($messagesByAgent));
$tpl->set('messageCounts', array_values($messagesByAgent));



$Result['content'] = $tpl->fetch();
$Result['path'] = array(
    array(
        'url' => erLhcoreClassDesign::baseurl('fbmessenger/index'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Statistics')
    )
);
