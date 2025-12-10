<?php

/**
 * php cron.php -s site_admin -e fbmessenger -c cron/masssending
 * */

$db = ezcDbInstance::get();

$db->beginTransaction();

try {
    $stmt = $db->prepare('UPDATE lhc_fbmessengerwhatsapp_message SET status = :status WHERE status = :status_scheduled AND scheduled_at < :ts');
    $stmt->bindValue(':status', \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_PENDING_PROCESS, PDO::PARAM_INT);
    $stmt->bindValue(':status_scheduled', \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_SCHEDULED, PDO::PARAM_INT);
    $stmt->bindValue(':ts', time(), PDO::PARAM_INT);
    $stmt->execute();

    $db->commit();
} catch (Exception $e) {
    // Someone is already processing. So we just ignore and retry later
    return;
}

$db->beginTransaction();

// Regular sending flow
try {
    $stmt = $db->prepare('SELECT id FROM lhc_fbmessengerwhatsapp_message WHERE status = :status LIMIT :limit FOR UPDATE ');
    $stmt->bindValue(':limit', 60, PDO::PARAM_INT);
    $stmt->bindValue(':status', \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_PENDING_PROCESS, PDO::PARAM_INT);
    $stmt->execute();
    $chatsId = $stmt->fetchAll(PDO::FETCH_COLUMN);
} catch (Exception $e) {
    // Someone is already processing. So we just ignore and retry later
    return;
}

if (!empty($chatsId)) {

    $instance = LiveHelperChatExtension\fbmessenger\providers\FBMessengerWhatsAppLiveHelperChat::getInstance();

    $templatesCache = [];
    $phonesCache = [];

    $mbOptions = \erLhcoreClassModelChatConfig::fetch('fbmessenger_options');
    $data = (array)$mbOptions->data;

    // Lock messages
    $stmt = $db->prepare('UPDATE lhc_fbmessengerwhatsapp_message SET status = :status WHERE id IN (' . implode(',', $chatsId) . ')');
    $stmt->bindValue(':status', \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_IN_PROCESS, PDO::PARAM_INT);
    $stmt->execute();
    $db->commit();

    $messages = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::getList(['filterin' => ['id' => $chatsId]]);

    if (!empty($messages)) {
        foreach ($messages as $message) {

            $status_contact = LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppContact::getList(['filter' => ['phone' => $message->phone]]);
            $shouldSkip = false;
            foreach ($status_contact as $contact) {
                if ($contact->disabled > 0) {
                    $shouldSkip = true;
                    $message->removeThis();
                    break;
                }
            }

            if ($shouldSkip) {
                continue;
            }

            if ($message->business_account !== null) {
                $instance->setAccessToken($message->business_account->access_token);
                $instance->setBusinessAccountID($message->business_account->business_account_id);

                $templates = isset($templatesCache[$message->business_account->business_account_id]) ? $templatesCache[$message->business_account->business_account_id] : $instance->getTemplates();
                $phones = isset($phonesCache[$message->business_account->business_account_id]) ? $phonesCache[$message->business_account->business_account_id] : $instance->getPhones();

                $templatesCache[$message->business_account->business_account_id] = $templates;
                $phonesCache[$message->business_account->business_account_id] = $phones;
            } else {
                $instance->setAccessToken($data['whatsapp_access_token']);
                $instance->setBusinessAccountID($data['whatsapp_business_account_id']);

                $templates = isset($templatesCache[0]) ? $templatesCache[0] : $instance->getTemplates();
                $phones = isset($phonesCache[0]) ? $phonesCache[0] : $instance->getPhones();

                $templatesCache[0] = $templates;
                $phonesCache[0] = $phones;
            }

            $instance->sendTemplate($message, $templates, $phones);

            if ($message->campaign_recipient !== null) {
                $message->campaign_recipient->send_at = time();

                if (
                    $message->status == \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppMessage::STATUS_REJECTED
                ) {
                    $message->campaign_recipient->status = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_FAILED;

                    // 🔴 Desactivar contacto si el mensaje falló o fue rechazado
                    $contacts = LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppContact::getList([
                        'filter' => ['phone' => $message->phone]
                    ]);

                    if (!empty($contacts)) {
                        foreach ($contacts as $contact) {
                            $contact->disabled = 1;
                            $contact->delivery_status = LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppContact::DELIVERY_STATUS_FAILED;
                            $contact->updateThis(['update' => ['disabled', 'delivery_status']]);
                        }
                    }
                } else {
                    $message->campaign_recipient->status = \LiveHelperChatExtension\fbmessenger\providers\erLhcoreClassModelMessageFBWhatsAppCampaignRecipient::STATUS_SENT;
                }

                $message->campaign_recipient->updateThis(['update' => ['send_at', 'status']]);
            }
        }
    }

} else {
    $db->rollback();
}
