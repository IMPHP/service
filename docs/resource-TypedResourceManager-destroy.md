# [Service](resource.md) / [TypedResourceManager](resource-TypedResourceManager.md) :: destroy
 > im\resource\TypedResourceManager
____

## Description
Destroy this entire instance

This will clear all of the resources within this inctance, but
only after it has deinitialized all of the `im\resource\ResourceProvider` instances.

## Synopsis
```php
public destroy(): void
```
