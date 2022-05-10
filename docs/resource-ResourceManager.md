# [Service](resource.md) / ResourceManager
 > im\resource\ResourceManager
____

## Description
Defines a container that stores resource objects

A resource object is an object that uses global configurations
that can be shared across the project. This could be something
like a database as an example.

## Synopsis
```php
interface ResourceManager {

    // Methods
    hasResource(string $identifier): bool
    getResource(string $identifier): object
}
```

## Methods
| Name | Description |
| :--- | :---------- |
| [__ResourceManager&nbsp;::&nbsp;hasResource__](resource-ResourceManager-hasResource.md) | Check to see if a resource exists |
| [__ResourceManager&nbsp;::&nbsp;getResource__](resource-ResourceManager-getResource.md) | Get a resource from this manager |
