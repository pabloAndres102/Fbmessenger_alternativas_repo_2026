<?php

$def = new ezcPersistentObjectDefinition();
$def->table = "lhc_sns_sms_campaign"; // Nombre de la tabla
$def->class = "erLhcoreClassModelSmsCampaign"; // Clase del modelo

// ID
$def->idProperty = new ezcPersistentObjectIdProperty();
$def->idProperty->columnName = 'id';
$def->idProperty->propertyName = 'id';
$def->idProperty->generator = new ezcPersistentGeneratorDefinition('ezcPersistentNativeGenerator');

// Nombre de campaña
$def->properties['name'] = new ezcPersistentObjectProperty();
$def->properties['name']->columnName   = 'name';
$def->properties['name']->propertyName = 'name';
$def->properties['name']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

// Mensaje
$def->properties['message'] = new ezcPersistentObjectProperty();
$def->properties['message']->columnName   = 'message';
$def->properties['message']->propertyName = 'message';
$def->properties['message']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

// Teléfonos
$def->properties['phones'] = new ezcPersistentObjectProperty();
$def->properties['phones']->columnName   = 'phones';
$def->properties['phones']->propertyName = 'phones';
$def->properties['phones']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

// Estado (pending | scheduled | running | completed | failed)
$def->properties['status'] = new ezcPersistentObjectProperty();
$def->properties['status']->columnName   = 'status';
$def->properties['status']->propertyName = 'status';
$def->properties['status']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

// Programado (timestamp)
$def->properties['scheduled_at'] = new ezcPersistentObjectProperty();
$def->properties['scheduled_at']->columnName   = 'scheduled_at';
$def->properties['scheduled_at']->propertyName = 'scheduled_at';
$def->properties['scheduled_at']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

// Enviado (timestamp)
$def->properties['sent_at'] = new ezcPersistentObjectProperty();
$def->properties['sent_at']->columnName   = 'sent_at';
$def->properties['sent_at']->propertyName = 'sent_at';
$def->properties['sent_at']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

// created_at
$def->properties['created_at'] = new ezcPersistentObjectProperty();
$def->properties['created_at']->columnName   = 'created_at';
$def->properties['created_at']->propertyName = 'created_at';
$def->properties['created_at']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

// updated_at
$def->properties['updated_at'] = new ezcPersistentObjectProperty();
$def->properties['updated_at']->columnName   = 'updated_at';
$def->properties['updated_at']->propertyName = 'updated_at';
$def->properties['updated_at']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

return $def;

?>
