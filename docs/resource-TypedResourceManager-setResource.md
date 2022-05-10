# [Service](resource.md) / [TypedResourceManager](resource-TypedResourceManager.md) :: setResource
 > im\resource\TypedResourceManager
____

## Description
Set a resource for a specific identifier

The object passed to this method should be the actual resource object
and it's type must be a match to the identifier.

## Synopsis
```php
public setResource(string $identifier, object $provider): void
```

## Parameters
| Name | Description |
| :--- | :---------- |
| identifier | The resource identifier |
| provider | The actual resource object |
