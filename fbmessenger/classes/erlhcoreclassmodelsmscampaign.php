<?php

class erLhcoreClassModelSmsCampaign
{
    use erLhcoreClassDBTrait;

    public static $dbTable = 'lhc_sns_sms_campaign';
    public static $dbTableId = 'id';
    public static $dbSessionHandler = 'erLhcoreClassExtensionFbmessenger::getSession';
    public static $dbSortOrder = 'DESC';

    public $id = null;
    public $name = '';
    public $message = '';
    public $phones = '';
    public $status = 'pending';
    public $scheduled_at = 0;
    public $created_at = 0;
    public $updated_at = 0;

    public function getState()
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'message'     => $this->message,
            'phones'      => $this->phones,
            'status'      => $this->status,
            'scheduled_at'=> $this->scheduled_at,
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
        ];
    }
}
