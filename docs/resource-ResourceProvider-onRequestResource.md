# [Service](resource.md) / [ResourceProvider](resource-ResourceProvider.md) :: onRequestResource
 > im\resource\ResourceProvider
____

## Description
This is called by `im\resource\ResourceManager` every time the resource is requested.

## Synopsis
```php
onRequestResource(im\resource\ResourceManager $manager, string $identifier): object
```

## Parameters
| Name | Description |
| :--- | :---------- |
| manager | The `im\resource\ResourceManager` that called this method |
| identifier | The identifier that is being requested |

## Return
A resource that is type match to the $identifier
