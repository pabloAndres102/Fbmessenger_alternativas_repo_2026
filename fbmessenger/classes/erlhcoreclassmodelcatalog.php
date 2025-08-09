<?php
#[\AllowDynamicProperties]
class erLhcoreClassModelCatalog {

    use erLhcoreClassDBTrait;

    public static $dbTable = 'lhc_fbmessenger_catalog'; 
    public static $dbTableId = 'id';
    public static $dbSessionHandler = 'erLhcoreClassExtensionFbmessenger::getSession';
    public static $dbSortOrder = 'DESC';

    public function getState()
    {
        $stateArray = array(
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'image' => $this->image, 
        );

        return $stateArray;
    }

    public function __toString()
    {
        return $this->name;
    }

    public $id = null;
    public $name = '';
    public $code = '';
    public $image = ''; 
}
?>
