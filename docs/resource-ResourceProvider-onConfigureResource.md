# [Service](resource.md) / [ResourceProvider](resource-ResourceProvider.md) :: onConfigureResource
 > im\resource\ResourceProvider
____

## Description
This is called by `im\resource\ResourceManager` the first time
a resource is requested.

It allows a resource provider to setup and configure the resource,
before serving it.

## Synopsis
```php
onConfigureResource(im\resource\ResourceManager $manager, string $identifier, ...$args): bool
```

## Parameters
| Name | Description |
| :--- | :---------- |
| manager | The `im\resource\ResourceManager` that called this method |
| identifier | The identifier that was requested |
| args | The arguments that was parsed when adding this provider to $manager |

## Return
Should return `TRUE` on success and `FALSE` if setup failed
