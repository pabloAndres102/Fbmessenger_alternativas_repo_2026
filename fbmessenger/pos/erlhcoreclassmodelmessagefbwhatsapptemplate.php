<?php

$def = new ezcPersistentObjectDefinition();
$def->table = "lhc_fbmessengerwhatsapp_template"; 
$def->class = "erLhcoreClassModelMessageFBWhatsAppTemplate";

$def->idProperty = new ezcPersistentObjectIdProperty();
$def->idProperty->columnName = 'id';
$def->idProperty->propertyName = 'id';
$def->idProperty->generator = new ezcPersistentGeneratorDefinition('ezcPersistentNativeGenerator');

// name
$def->properties['name'] = new ezcPersistentObjectProperty();
$def->properties['name']->columnName   = 'name';
$def->properties['name']->propertyName = 'name';
$def->properties['name']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

// template_id
$def->properties['template_id'] = new ezcPersistentObjectProperty();
$def->properties['template_id']->columnName   = 'template_id';
$def->properties['template_id']->propertyName = 'template_id';
$def->properties['template_id']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

// language
$def->properties['language'] = new ezcPersistentObjectProperty();
$def->properties['language']->columnName   = 'language';
$def->properties['language']->propertyName = 'language';
$def->properties['language']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

// category
$def->properties['category'] = new ezcPersistentObjectProperty();
$def->properties['category']->columnName   = 'category';
$def->properties['category']->propertyName = 'category';
$def->properties['category']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

// components
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

// user_id
$def->properties['user_id'] = new ezcPersistentObjectProperty();
$def->properties['user_id']->columnName   = 'user_id';
$def->properties['user_id']->propertyName = 'user_id';
$def->properties['user_id']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

return $def;

?>
