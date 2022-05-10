# [Service](resource.md) / TypedResourceManager
 > im\resource\TypedResourceManager
____

## Description
An implementation of a `im\resource\ResourceManager`

This resource manager uses type safety by matching the resource
objects against the identifiers. As such, the identifiers used with this manager
is strictly forced to be the name of the objects class or one of it's parents.

## Synopsis
```php
class TypedResourceManager implements im\resource\ResourceManager {

    // Methods
    public __construct()
    public setResourceAlias(string $alias, string $identifier): void
    public setResourceProvider(string $identifier, im\resource\ResourceProvider|callable $provider, ...$args): void
    public setResource(string $identifier, object $provider): void
    public hasResource(string $identifier): bool
    public getResource(string $identifier): object
    public destroy(): void
}
```

## Methods
| Name | Description |
| :--- | :---------- |
| [__TypedResourceManager&nbsp;::&nbsp;\_\_construct__](resource-TypedResourceManager-__construct.md) |  |
| [__TypedResourceManager&nbsp;::&nbsp;setResourceAlias__](resource-TypedResourceManager-setResourceAlias.md) | Point an alias to another identifier  The alias itself must also be either the name of the object class or a parent class or interface |
| [__TypedResourceManager&nbsp;::&nbsp;setResourceProvider__](resource-TypedResourceManager-setResourceProvider.md) | Set a resource provider for a specific identifier  A resource provider is not the actual resource, but a `class` or `callable` that provides the resource when it's requested |
| [__TypedResourceManager&nbsp;::&nbsp;setResource__](resource-TypedResourceManager-setResource.md) | Set a resource for a specific identifier  The object passed to this method should be the actual resource object and it's type must be a match to the identifier |
| [__TypedResourceManager&nbsp;::&nbsp;hasResource__](resource-TypedResourceManager-hasResource.md) |  |
| [__TypedResourceManager&nbsp;::&nbsp;getResource__](resource-TypedResourceManager-getResource.md) |  |
| [__TypedResourceManager&nbsp;::&nbsp;destroy__](resource-TypedResourceManager-destroy.md) | Destroy this entire instance  This will clear all of the resources within this inctance, but only after it has deinitialized all of the `im\resource\ResourceProvider` instances |
