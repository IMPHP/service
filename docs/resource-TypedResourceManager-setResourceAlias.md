# [Service](resource.md) / [TypedResourceManager](resource-TypedResourceManager.md) :: setResourceAlias
 > im\resource\TypedResourceManager
____

## Description
Point an alias to another identifier

The alias itself must also be either the name of the object class
or a parent class or interface.

## Synopsis
```php
public setResourceAlias(string $alias, string $identifier): void
```

## Parameters
| Name | Description |
| :--- | :---------- |
| alias | An alias |
| identifier | The actual identifyer that the alias points to |

## Example 1
```
<?php
interface Database {}
class MySQL implements Database {}

$manager = new TypedResourceManager();
$manager->setResource("MySQL", new MySQL());
$manager->setResourceAlias("Database", "MySQL");
```
