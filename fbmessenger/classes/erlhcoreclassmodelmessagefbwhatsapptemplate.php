<?php
#[\AllowDynamicProperties]
class erLhcoreClassModelMessageFBWhatsAppTemplate
{
    use erLhcoreClassDBTrait;

    public static $dbTable = 'lhc_fbmessengerwhatsapp_template';

    public static $dbTableId = 'id';

    public static $dbSessionHandler = 'erLhcoreClassExtensionFbmessenger::getSession';

    public static $dbSortOrder = 'DESC';

    public function getState()
    {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'template_id' => $this->template_id,
            'language' => $this->language,
            'category' => $this->category,
            'components' => $this->components,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user_id' => $this->user_id,
        );
    }

    public $id = null;
    public $name = '';
    public $template_id = '';
    public $language = '';
    public $category = '';
    public $components = '';
    public $created_at = 0;
    public $updated_at = 0;
    public $user_id = 0;
}
