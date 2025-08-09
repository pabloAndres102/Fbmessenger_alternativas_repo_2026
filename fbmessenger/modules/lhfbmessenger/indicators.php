<?php

$tpl = erLhcoreClassTemplate::getInstance('lhfbmessenger/indicators.tpl.php');



$filterDateStart = strtotime($_GET['start']);
$filterDateEnd = strtotime($_GET['end']);

if (isset($_GET['status_statistic'])) {

    $status = $_GET['status_statistic'];
    $statusArray = explode(',', $status);
    $items = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::getList([
        'filter' => [
            'status' => $statusArray
        ],
        'filtergt' => [
            'created_at' => $filterDateStart
        ],
        'filterlte' => [
            'created_at ' => $filterDateEnd
        ]

    ]);
    $tpl->set('items', $items);

} 

if (isset($_GET['conversation'])) {
    $items = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::getList([
        'filtergt' => [
            'created_at' => $filterDateStart
        ],
        'filterlte' => [
            'created_at ' => $filterDateEnd
        ],
        'filtergt' => [
            'chat_id' => 0
        ]
    ]);
    $tpl->set('items', $items);
}



$Result['content'] = $tpl->fetch();
$Result['path'] = array(
    array('url' => erLhcoreClassDesign::baseurl('fbmessenger/index'), 'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Statistics')),
    array(
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Indicator')
    )
);
