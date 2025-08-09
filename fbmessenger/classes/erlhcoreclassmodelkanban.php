<?php

#[\AllowDynamicProperties]
class erLhcoreClassModelKanban
{
    use erLhcoreClassDBTrait;

    // Tabla específica para esta extensión (cambia el nombre si quieres)
    public static $dbTable = 'lhc_fbmessenger_kanban';
    public static $dbTableId = 'id';

    // Usamos el handler de sesión de la extensión fbmessenger
    public static $dbSessionHandler = 'erLhcoreClassExtensionFbmessenger::getSession';

    public static $dbSortOrder = 'DESC';

    public function getState()
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'color' => $this->color,
            'posicion' => $this->posicion,
        ];
    }

    public function __toString()
    {
        return $this->nombre;
    }

    public $id = null;
    public $nombre = '';
    public $color = '';
    public $posicion = '';
}
