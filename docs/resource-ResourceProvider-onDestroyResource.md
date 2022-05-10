# [Service](resource.md) / [ResourceProvider](resource-ResourceProvider.md) :: onDestroyResource
 > im\resource\ResourceProvider
____

## Description
This is called by `im\resource\ResourceManager` when it's being destroyed.

It allows a resource provider to do some finalization before being shut down.

## Synopsis
```php
onDestroyResource(im\resource\ResourceManager $manager, string $identifier): bool
```

## Parameters
| Name | Description |
| :--- | :---------- |
| manager | The `im\resource\ResourceManager` that called this method |
| identifier | The identifier that is being terminated |

## Return
Should return `TRUE` on success and `FALSE` on failure
