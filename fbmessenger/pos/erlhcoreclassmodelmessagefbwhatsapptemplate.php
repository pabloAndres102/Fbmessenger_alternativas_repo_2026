<?php

$def = new ezcPersistentObjectDefinition();
$def->table = "lhc_fbmessenger_whatsapp_template";
$def->class = "LiveHelperChatExtension\\fbmessenger\\providers\\erLhcoreClassModelMessageFBWhatsAppTemplate";

$def->idProperty = new ezcPersistentObjectIdProperty();
$def->idProperty->columnName   = 'id';
$def->idProperty->propertyName = 'id';
$def->idProperty->generator    = new ezcPersistentGeneratorDefinition('ezcPersistentNativeGenerator');

// name
$def->properties['name'] = new ezcPersistentObjectProperty();
$def->properties['name']->columnName   = 'name';
$def->properties['name']->propertyName = 'name';
$def->properties['name']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

// language
$def->properties['language'] = new ezcPersistentObjectProperty();
$def->properties['language']->columnName   = 'language';
$def->properties['language']->propertyName = 'language';
$def->properties['language']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

// status
$def->properties['status'] = new ezcPersistentObjectProperty();
$def->properties['status']->columnName   = 'status';
$def->properties['status']->propertyName = 'status';
$def->properties['status']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

// category
$def->properties['category'] = new ezcPersistentObjectProperty();
$def->properties['category']->columnName   = 'category';
$def->properties['category']->propertyName = 'category';
$def->properties['category']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

// components (json)
$def->properties['components'] = new ezcPersistentObjectProperty();
$def->properties['components']->columnName   = 'components';
$def->properties['components']->propertyName = 'components';
$def->properties['components']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

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

// waba_id
$def->properties['waba_id'] = new ezcPersistentObjectProperty();
$def->properties['waba_id']->columnName   = 'waba_id';
$def->properties['waba_id']->propertyName = 'waba_id';
$def->properties['waba_id']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

// template_id
$def->properties['template_id'] = new ezcPersistentObjectProperty();
$def->properties['template_id']->columnName   = 'template_id';
$def->properties['template_id']->propertyName = 'template_id';
$def->properties['template_id']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

return $def;

?>
