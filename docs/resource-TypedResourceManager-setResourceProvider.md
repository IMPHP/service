# [Service](resource.md) / [TypedResourceManager](resource-TypedResourceManager.md) :: setResourceProvider
 > im\resource\TypedResourceManager
____

## Description
Set a resource provider for a specific identifier

A resource provider is not the actual resource, but a `class` or `callable` that
provides the resource when it's requested.

 > A callable is only called ones. After the initial call, the object returned will be cached for future calls.  

## Synopsis
```php
public setResourceProvider(string $identifier, im\resource\ResourceProvider|callable $provider, ...$args): void
```

## Parameters
| Name | Description |
| :--- | :---------- |
| identifier | The resource identifier |
| provider | The resource provider |
| args | Additional arguments that will be passed to the initial call to the provider |

## Example 1
```
<?php
$manager = new TypedResourceManager();
$manager->setResourceProvider("SomeResource", function(ResourceManager $manager, string $identifier, ...$args){
    return new SomeResource();
});

$resource = $manager->getResource("SomeResource");
```
