<?php

$tpl = erLhcoreClassTemplate::getInstance('lhfbwhatsappmessaging/editcampaign.tpl.php');

$item = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaign::fetch($Params['user_parameters']['id']);
$tpl->set('tab','');

$instance = LiveHelperChatExtension\fbmessenger\providers\FBMessengerWhatsAppLiveHelperChat::getInstance();



if (isset($_POST['business_account_id']) && $_POST['business_account_id'] > 0) {
    $Params['user_parameters_unordered']['business_account_id'] = (int)$_POST['business_account_id'];
}

if ($item->business_account_id > 0) {
    $account = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppAccount::fetch($item->business_account_id);
    $instance->setAccessToken($account->access_token);
    $instance->setBusinessAccountID($account->business_account_id);
    $tpl->set('business_account
    _id', $account->id);
}


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
}

if (ezcInputForm::hasPostData()) {

    if (isset($_POST['Cancel_page'])) {
        erLhcoreClassModule::redirect('fbwhatsappmessaging/campaign');
        exit ;
    }

    if (!isset($_POST['csfr_token']) || !$currentUser->validateCSFRToken($_POST['csfr_token'])) {
        erLhcoreClassModule::redirect('fbwhatsappmessaging/campaign');
        exit;
    }

    if (isset($_POST['PauseCampaign'])) {
        \LiveHelperChatExtension\fbmessenger\providers\FBMessengerWhatsAppMailingValidator2::pauseCampaign($item);
        erLhcoreClassModule::redirect('fbwhatsappmessaging/editcampaign','/' . $item->id);
        exit;
    }

    $Errors = \LiveHelperChatExtension\fbmessenger\providers\FBMessengerWhatsAppMailingValidator2::validateCampaign($item);

    if (count($Errors) == 0) {
        try {
            $item->saveThis();

            if (isset($_POST['Update_page'])) {
                $tpl->set('updated',true);
            } else {
                erLhcoreClassModule::redirect('fbwhatsappmessaging/campaign');

                exit;
            }

        } catch (Exception $e) {
            $tpl->set('errors',array($e->getMessage()));
        }

    } else {
        $tpl->set('errors',$Errors);
    }
}



$tpl->setArray(array(
    'item' => $item,
    'templates' => $templates,
    'phones' => $phones
));

$Result['content'] = $tpl->fetch();
$Result['additional_footer_js'] = '<script type="text/javascript" src="'.erLhcoreClassDesign::designJS('js/extension.fbwhatsapp.js').'"></script>';

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
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'Edit')
    )
);

?>