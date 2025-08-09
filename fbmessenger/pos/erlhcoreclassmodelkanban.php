<?php

$def = new ezcPersistentObjectDefinition();
$def->table = "lhc_fbmessenger_kanban"; // Nombre de la tabla específica de la extensión
$def->class = "erLhcoreClassModelKanban"; // Nombre de la clase correspondiente

$def->idProperty = new ezcPersistentObjectIdProperty();
$def->idProperty->columnName = 'id';
$def->idProperty->propertyName = 'id';
$def->idProperty->generator = new ezcPersistentGeneratorDefinition('ezcPersistentNativeGenerator');

// Propiedad 'nombre'
$def->properties['nombre'] = new ezcPersistentObjectProperty();
$def->properties['nombre']->columnName = 'nombre';
$def->properties['nombre']->propertyName = 'nombre';
$def->properties['nombre']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

// Propiedad 'color'
$def->properties['color'] = new ezcPersistentObjectProperty();
$def->properties['color']->columnName = 'color';
$def->properties['color']->propertyName = 'color';
$def->properties['color']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

// Propiedad 'posicion'
$def->properties['posicion'] = new ezcPersistentObjectProperty();
$def->properties['posicion']->columnName = 'posicion';
$def->properties['posicion']->propertyName = 'posicion';
$def->properties['posicion']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

return $def;
?>
