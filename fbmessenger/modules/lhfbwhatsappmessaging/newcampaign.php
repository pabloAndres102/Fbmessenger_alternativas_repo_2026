<?php

$tpl = erLhcoreClassTemplate::getInstance('lhfbwhatsappmessaging/newcampaign.tpl.php');

$item = new LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaign();
$fbOptions = erLhcoreClassModelChatConfig::fetch('fbmessenger_options');
$data = (array)$fbOptions->data;

if (isset($_POST['Cancel_page'])) {
    erLhcoreClassModule::redirect('fbwhatsappmessaging/campaign');
    exit;
}

$instance = LiveHelperChatExtension\fbmessenger\providers\FBMessengerWhatsAppLiveHelperChat::getInstance();

if (isset($_POST['business_account_id']) && $_POST['business_account_id'] > 0) {
    $item->business_account_id = $Params['user_parameters_unordered']['business_account_id'] = (int)$_POST['business_account_id'];
}

if ($item->business_account_id > 0) {
    $account = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppAccount::fetch($item->business_account_id);
    $instance->setAccessToken($account->access_token);
    $instance->setBusinessAccountID($account->business_account_id);
    $tpl->set('business_account_id', $account->id);
}

$templates = $instance->getTemplates();
$phones = $instance->getPhones();


if (ezcInputForm::hasPostData()) {

    if (!isset($_POST['csfr_token']) || !$currentUser->validateCSFRToken($_POST['csfr_token'])) {
        erLhcoreClassModule::redirect('mailing/campaign');
        exit;
    }


    $items = array();

    if (isset($_POST['nombre_archivo1'])) {
        $item->pdf_name =  $_POST['nombre_archivo1'];
        // print_r($item->pdf_name);
    }

    if (isset($_POST['products'])) {
        $item->products = $_POST['products'];
    }

    if (isset($_POST['offert'])) {
        $offer_array = [];
        $offer_array[] = $_POST['offert'];

        $expiration_date = new DateTime($_POST['expiration_offert']);
        $expiration_timestamp = $expiration_date->getTimestamp() * 1000;
        $offer_array[] = $expiration_timestamp;

        $item->offer = $offer_array;
    }


    if (isset($_FILES['image_general'])) {
        $files_campaign = [];
        $imageCards = $_FILES['image_general'];

        // Ahora $imageCards es un array de archivos, puedes recorrerlo
        foreach ($imageCards['tmp_name'] as $index => $name) {
            $file = $imageCards['tmp_name'][$index];

            if (!empty($file)) {
                $archivo_bytes = file_get_contents($file);
            }

            $token = $data['whatsapp_access_token'];
            $app_id = $data['app_id'];
            $whatsapp_business_account_id = $data['whatsapp_business_account_id'];
            $mime_type = mime_content_type($file);
            if ($mime_type == 'image/webp') {
                $image = imagecreatefromstring(file_get_contents($file));
                $png_file = tempnam(sys_get_temp_dir(), 'converted_image_') . '.png';
                imagepng($image, $png_file);
                imagedestroy($image);
                $file = $png_file;
                $mime_type = 'image/png';
            }
            $phone_numbers = explode(',', $data['whatsapp_business_account_phone_number']);
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://graph.facebook.com/v20.0/' . $phone_numbers[0]. '/media',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'messaging_product' => 'whatsapp',
                    'file' => new CURLFILE($file, $mime_type)
                ),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . $token,
                    'Cookie: ps_l=0; ps_n=0'
                ),
            ));

            $response = curl_exec($curl);
            $response = json_decode($response, true);

            curl_close($curl);

            $files_campaign[] = $response;
        }
        $item->files_campaign = $files_campaign;
    }



    if (isset($_FILES['imageCard'])) {
        $archivos = [];
        $imageCards = $_FILES['imageCard'];
        foreach ($imageCards['tmp_name'] as $index => $name) {
            $file = $imageCards['tmp_name'][$index];




            if (!empty($file)) {
                $archivo_bytes = file_get_contents($file);
            }


            $token = $data['whatsapp_access_token'];
            $app_id = $data['app_id'];
            $whatsapp_business_account_id = $data['whatsapp_business_account_id'];
            $mime_type = mime_content_type($file);
            if ($mime_type == 'image/webp') {
                $image = imagecreatefromstring(file_get_contents($file));
                $png_file = tempnam(sys_get_temp_dir(), 'converted_image_') . '.png';
                imagepng($image, $png_file);
                imagedestroy($image);
                $file = $png_file;
                $mime_type = 'image/png';
            }

            $curl = curl_init();
            $phone_numbers = explode(',', $data['whatsapp_business_account_phone_number']);
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://graph.facebook.com/v20.0/' . $phone_numbers[0] .'/media',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'messaging_product' => 'whatsapp',
                    'file' => new CURLFILE($file, $mime_type)
                ),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . $token,
                    'Cookie: ps_l=0; ps_n=0'
                ),
            ));

            $response = curl_exec($curl);
            $response = json_decode($response, true);

            curl_close($curl);

            $archivos[] = $response['id'];
        }
        $item->image_ids = $archivos;
    }









    $Errors = LiveHelperChatExtension\fbmessenger\providers\FBMessengerWhatsAppMailingValidator::validateCampaign($item);

    if (count($Errors) == 0) {
        try {
            $item->user_id = $currentUser->getUserID();
            $item->saveThis();

            // print_r('PASO');
            $definition = array(
                'ml' => new ezcInputFormDefinitionElement(
                    ezcInputFormDefinitionElement::OPTIONAL,
                    'int',
                    array('min_range' => 1),
                    FILTER_REQUIRE_ARRAY
                ),
            );

            $form = new ezcInputForm(INPUT_POST, $definition);
            $Errors = array();

            $statistic = ['skipped' => 0, 'already_exists' => 0, 'imported' => 0, 'unassigned' => 0];

            $listPrivate = erLhcoreClassUser::instance()->hasAccessTo('lhfbwhatsappmessaging', 'all_contact_list');

            if ($form->hasValidData('ml') && !empty($form->ml)) {
                foreach ($form->ml as $ml) {
                    foreach (\LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppContactListContact::getList(['limit' => false, 'filter' => ['contact_list_id' => $ml]]) as $mailingRecipient) {

                        // Skip private contact in public list
                        if ($listPrivate === false && $mailingRecipient->private == 1 && $mailingRecipient->user_id != (int)\erLhcoreClassUser::instance()->getUserID()) {
                            $statistic['skipped']++;
                            continue;
                        }

                        if (isset($_POST['export_action']) && $_POST['export_action'] == 'unassign') {
                            if ($mailingRecipient->mailing_recipient instanceof \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppContact) {
                                foreach (\LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getList(['filter' => ['campaign_id' => $campaign->id, 'phone' => $mailingRecipient->mailing_recipient->phone]]) as $campaignRecipient) {
                                    $campaignRecipient->removeThis();
                                    $statistic['unassigned']++;
                                }
                            }
                            continue;
                        }

                        if (!($mailingRecipient->mailing_recipient instanceof \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppContact) || $mailingRecipient->mailing_recipient->disabled == 1) {
                            $statistic['skipped']++;
                            continue;
                        }

                        if (\LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::getCount(['filter' => ['campaign_id' => $campaign->id, 'phone' => $mailingRecipient->mailing_recipient->phone]]) == 1) {
                            $statistic['already_exists']++;
                            continue;
                        }

                        $campaignRecipient = new \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient();
                        $campaignRecipient->campaign_id = $item->id;
                        $campaignRecipient->recipient_id = $mailingRecipient->contact_id;
                        $campaignRecipient->email = $mailingRecipient->mailing_recipient->email;
                        $campaignRecipient->phone = $mailingRecipient->mailing_recipient->phone;
                        $campaignRecipient->saveThis();
                        $statistic['imported']++;
                    }
                }

                $tpl->set('statistic', $statistic);
                $tpl->set('updated', true);
            } else {
                $tpl->set('errors', ['Please choose at-least one mailing list']);
            }




            if (isset($_POST['Save_continue'])) {

                $campaignId = $item->id;
                if (!empty($campaignId)) {
                    $campaign = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaign::fetch($campaignId);

                    if ($campaign instanceof \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaign) {
                        $campaign->enabled = 1;
                        if (isset($_POST['ml'])) {
                            $campaign->lists_id = json_encode($_POST['ml']);
                        }

                        $campaign->saveThis();
                    }
                    header('Location: ' . erLhcoreClassDesign::baseurl('fbwhatsappmessaging/campaign'));
                    $_SESSION['create'] = 'Su campaña se creo con exito.';
                }
            }

            exit;
        } catch (Exception $e) {
            $tpl->set('errors', array($e->getMessage()));
        }
    } else {
        $tpl->set('errors', $Errors);
    }
}


// print_r($item);

$tpl->setArray(array(
    'item' => $item,
    'templates' => $templates,
    'phones' => $phones
));

$Result['content'] = $tpl->fetch();
$Result['additional_footer_js'] = '<script type="text/javascript" src="' . erLhcoreClassDesign::designJS('js/extension.fbwhatsapp.js') . '"></script>';

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
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('module/fbmessenger', 'New')
    )
);
