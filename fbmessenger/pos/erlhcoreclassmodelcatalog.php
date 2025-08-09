<?php

$def = new ezcPersistentObjectDefinition();
$def->table = "lhc_fbmessenger_catalog"; // Cambia el nombre de la tabla
$def->class = "erLhcoreClassModelCatalog"; // Cambia el nombre de la clase

$def->idProperty = new ezcPersistentObjectIdProperty();
$def->idProperty->columnName = 'id';
$def->idProperty->propertyName = 'id';
$def->idProperty->generator = new ezcPersistentGeneratorDefinition(  'ezcPersistentNativeGenerator' );

// Añadir la propiedad 'name'
$def->properties['name'] = new ezcPersistentObjectProperty();
$def->properties['name']->columnName   = 'name'; // Cambia el nombre de la columna
$def->properties['name']->propertyName = 'name';
$def->properties['name']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

// Añadir la propiedad 'code'
$def->properties['code'] = new ezcPersistentObjectProperty();
$def->properties['code']->columnName   = 'code'; // Cambia el nombre de la columna
$def->properties['code']->propertyName = 'code';
$def->properties['code']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

// Añadir la propiedad 'image'
$def->properties['image'] = new ezcPersistentObjectProperty();
$def->properties['image']->columnName   = 'image'; // Cambia el nombre de la columna
$def->properties['image']->propertyName = 'image';
$def->properties['image']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

return $def;

?>
