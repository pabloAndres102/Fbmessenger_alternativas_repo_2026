<?php

namespace LiveHelperChatExtension\fbmessenger\providers;

class erLhcoreClassModelMessageFBWhatsAppTemplate
{
    use \erLhcoreClassDBTrait;

    public static $dbTable = 'lhc_fbmessengerwhatsapp_template';

    public static $dbTableId = 'id';

    public static $dbSessionHandler = 'erLhcoreClassExtensionFbmessenger::getSession';

    public static $dbSortOrder = 'DESC';

    public function getState()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'language' => $this->language,
            'status' => $this->status,
            'category' => $this->category,
            'components' => $this->components,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'waba_id' => $this->waba_id,
            'template_id' => $this->template_id,
        ];
    }

    public function beforeSave($params = [])
    {
        if ($this->created_at == 0) {
            $this->created_at = time();
        }

        $this->updated_at = time();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function __get($var)
    {
        switch ($var) {
            case 'created_at_front':
                $this->created_at_front = date('Ymd') == date('Ymd', $this->created_at) ? date(\erLhcoreClassModule::$dateHourFormat, $this->created_at) : date(\erLhcoreClassModule::$dateDateHourFormat, $this->created_at);
                return $this->created_at_front;

            case 'updated_at_front':
                $this->updated_at_front = date(\erLhcoreClassModule::$dateDateHourFormat, $this->updated_at);
                return $this->updated_at_front;

            case 'components_array':
                if (!empty($this->components)) {
                    $jsonData = json_decode($this->components, true);
                    $this->components_array = $jsonData !== null ? $jsonData : [];
                } else {
                    $this->components_array = [];
                }
                return $this->components_array;

            default:
                ;
                break;
        }
    }

    // Campos posibles de status
    const STATUS_PENDING = 0;
    const STATUS_APPROVED = 1;
    const STATUS_REJECTED = 2;

    public $id = null;
    public $name = '';
    public $language = '';
    public $status = self::STATUS_PENDING;
    public $category = '';
    public $components = ''; // JSON con estructura del template (body, header, footer, botones)
    public $created_at = 0;
    public $updated_at = 0;
    public $waba_id = '';
    public $template_id = ''; // ID de Meta/Facebook si existe
}
