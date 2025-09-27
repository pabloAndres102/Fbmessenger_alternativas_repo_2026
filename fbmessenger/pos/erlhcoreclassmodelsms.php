<?php

$def = new ezcPersistentObjectDefinition();
$def->table = "lhc_sns_sms_message"; // Nombre de la tabla
$def->class = "erLhcoreClassModelSms"; // Clase del modelo

// ID
$def->idProperty = new ezcPersistentObjectIdProperty();
$def->idProperty->columnName = 'id';
$def->idProperty->propertyName = 'id';
$def->idProperty->generator = new ezcPersistentGeneratorDefinition('ezcPersistentNativeGenerator');

// Teléfono
$def->properties['phone'] = new ezcPersistentObjectProperty();
$def->properties['phone']->columnName   = 'phone';
$def->properties['phone']->propertyName = 'phone';
$def->properties['phone']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

// Mensaje
$def->properties['message'] = new ezcPersistentObjectProperty();
$def->properties['message']->columnName   = 'message';
$def->properties['message']->propertyName = 'message';
$def->properties['message']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

// MessageId de AWS
$def->properties['message_id'] = new ezcPersistentObjectProperty();
$def->properties['message_id']->columnName   = 'message_id';
$def->properties['message_id']->propertyName = 'message_id';
$def->properties['message_id']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

// Status (sent | failed)
$def->properties['status'] = new ezcPersistentObjectProperty();
$def->properties['status']->columnName   = 'status';
$def->properties['status']->propertyName = 'status';
$def->properties['status']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

// Error (nullable)
$def->properties['error'] = new ezcPersistentObjectProperty();
$def->properties['error']->columnName   = 'error';
$def->properties['error']->propertyName = 'error';
$def->properties['error']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

// created_at (timestamp)
$def->properties['created_at'] = new ezcPersistentObjectProperty();
$def->properties['created_at']->columnName   = 'created_at';
$def->properties['created_at']->propertyName = 'created_at';
$def->properties['created_at']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

// updated_at (timestamp)
$def->properties['updated_at'] = new ezcPersistentObjectProperty();
$def->properties['updated_at']->columnName   = 'updated_at';
$def->properties['updated_at']->propertyName = 'updated_at';
$def->properties['updated_at']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

return $def;

?>
