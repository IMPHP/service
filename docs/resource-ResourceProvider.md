# [Service](resource.md) / ResourceProvider
 > im\resource\ResourceProvider
____

## Description
A resource provider that can be added to `im\resource\ResourceManager`.

The purpose of a provider is to provide resources that can be configured
only when it's required. For an example a database resource can wait
until it's being requested, before it actually connects to a database server or
openes a database file.

The `im\resource\ResourceManager` will also allow a provider to finalize
once it's no longer needed. For an example disconnecting a database connection,
or saving changes of some sorts to a file.

## Synopsis
```php
interface ResourceProvider {

    // Methods
    onConfigureResource(im\resource\ResourceManager $manager, string $identifier, ...$args): bool
    onDestroyResource(im\resource\ResourceManager $manager, string $identifier): bool
    onRequestResource(im\resource\ResourceManager $manager, string $identifier): object
}
```

## Methods
| Name | Description |
| :--- | :---------- |
| [__ResourceProvider&nbsp;::&nbsp;onConfigureResource__](resource-ResourceProvider-onConfigureResource.md) | This is called by `im\resource\ResourceManager` the first time a resource is requested |
| [__ResourceProvider&nbsp;::&nbsp;onDestroyResource__](resource-ResourceProvider-onDestroyResource.md) | This is called by `im\resource\ResourceManager` when it's being destroyed |
| [__ResourceProvider&nbsp;::&nbsp;onRequestResource__](resource-ResourceProvider-onRequestResource.md) | This is called by `im\resource\ResourceManager` every time the resource is requested |
