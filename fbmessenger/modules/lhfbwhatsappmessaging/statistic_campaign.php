<?php

$tpl = erLhcoreClassTemplate::getInstance('lhfbwhatsappmessaging/statistic_campaign.tpl.php');

$id = $_GET['id'];


$item = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaign::fetch($id);



$instance = LiveHelperChatExtension\fbmessenger\providers\FBMessengerWhatsAppLiveHelperChat::getInstance();


$department = erLhcoreClassModelDepartament::fetch($item->dep_id);


$tpl->set('department',$department->name);


$templates = $instance->getTemplates();
$phones = $instance->getPhones();



$messages = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::getList();

$generatedConversations = 0;



foreach ($messages as $message) {
    if($item->template == $message->template && $messages->chat_id > 0){
        $generatedConversations = $generatedConversations + 1 ;
    }
}

$tpl->set('generatedConversations', $generatedConversations);

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

   erLhcoreClassChatMail::sendInfoMail($currentUser->getUserData(),$_POST['email'],$additionalContent);

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
        'url' => erLhcoreClassDesign::baseurl('fbmessenger/index') ,
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger','Facebook chat'),
    ),
    array(
        'url' => erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaign'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Campaigns')
    ),
    array(
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Statistics')
    )
);

?>