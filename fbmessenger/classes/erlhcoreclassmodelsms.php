<?php

use Aws\Sns\SnsClient;
use Aws\Exception\AwsException;

class erLhcoreClassModelSms
{
    use erLhcoreClassDBTrait;

    public static $dbTable = 'lhc_sns_sms_message';
    public static $dbTableId = 'id';
    public static $dbSessionHandler = 'erLhcoreClassExtensionFbmessenger::getSession';
    public static $dbSortOrder = 'DESC';

    // --- Propiedades ---
    public $id         = null;
    public $phone      = '';
    public $message    = '';
    public $message_id = '';
    public $status     = '';   // sent | failed
    public $error      = '';
    public $campaign   = '';
    public $scheduled_at = 0;
    public $sent_at = 0;
    public $created_at = 0;
    public $updated_at = 0;

    protected static function getClient()
    {


        $fbOptions = erLhcoreClassModelChatConfig::fetch('fbmessenger_options');
        $data = (array)$fbOptions->data;

        $awsKey    = $data['aws_key']    ?? null;
        $awsSecret = $data['aws_secret'] ?? null;

        if (empty($awsKey) || empty($awsSecret)) {
            throw new Exception("Credenciales AWS no configuradas en fb_options");
        }

        return new SnsClient([
            'region'  => 'us-east-1',
            'version' => '2010-03-31',
            'credentials' => [
                'key'    => $awsKey,
                'secret' => $awsSecret,
            ],
        ]);
    }

    public function getState()
    {
        return [
            'id'         => $this->id,
            'phone'      => $this->phone,
            'message'    => $this->message,
            'message_id' => $this->message_id,
            'status'     => $this->status,
            'error'      => $this->error,
            'campaign'   => $this->campaign,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function __toString()
    {
        return $this->message;
    }

    // --- Envío simple ---
    public static function sendSMS($phone, $message, $campaign = '')
    {
        $sns = self::getClient();
        $db  = ezcDbInstance::get();
        $createdAt = time();

        try {
            if (empty($phone) || empty($message)) {
                throw new \Exception('Número o mensaje vacío');
            }

            $result = $sns->publish([
                'Message'     => $message,
                'PhoneNumber' => $phone,
                'MessageAttributes' => [
                    'AWS.SNS.SMS.SMSType' => [
                        'DataType'    => 'String',
                        'StringValue' => 'Transactional',
                    ],
                ],
            ]);

            $messageId = $result->get('MessageId') ?: null;

            $stmt = $db->prepare("
                INSERT INTO lhc_sns_sms_message
                (phone, message, message_id, status, campaign, created_at, updated_at)
                VALUES (:phone, :message, :message_id, 'sent', :campaign, :created_at, :updated_at)
            ");
            $stmt->bindValue(':phone', $phone);
            $stmt->bindValue(':message', $message);
            $stmt->bindValue(':message_id', $messageId);
            $stmt->bindValue(':campaign', $campaign);
            $stmt->bindValue(':created_at', $createdAt, PDO::PARAM_INT);
            $stmt->bindValue(':updated_at',                     $createdAt, PDO::PARAM_INT);
            $stmt->execute();

            return [
                'success'   => true,
                'status'    => 'sent',
                'messageId' => $messageId,
                'phone'     => $phone,
                'error'     => null
            ];
        } catch (AwsException $e) {
            $errorMsg = $e->getAwsErrorMessage() ?: $e->getMessage();
        } catch (\Exception $e) {
            $errorMsg = $e->getMessage();
        }

        // Guardar error
        $stmt = $db->prepare("
            INSERT INTO lhc_sns_sms_message
            (phone, message, status, error, campaign, created_at, updated_at)
            VALUES (:phone, :message, 'failed', :error, :campaign, :created_at, :updated_at)
        ");
        $stmt->bindValue(':phone', $phone);
        $stmt->bindValue(':message', $message);
        $stmt->bindValue(':error', $errorMsg);
        $stmt->bindValue(':campaign', $campaign);
        $stmt->bindValue(':created_at', $createdAt, PDO::PARAM_INT);
        $stmt->bindValue(':updated_at', $createdAt, PDO::PARAM_INT);
        $stmt->execute();

        return [
            'success' => false,
            'status'  => 'failed',
            'phone'   => $phone,
            'error'   => $errorMsg
        ];
    }

    // --- Envío masivo (campaña) ---
    public static function sendCampaign(array $phones, $message, $campaign)
    {
        $results = [];
        foreach ($phones as $phone) {
            $results[] = self::sendSMS($phone, $message, $campaign);
        }
        return $results;
    }
}
