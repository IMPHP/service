# Service
____

## Description
A resource managerment library

## Interfaces
| Name | Description |
| :--- | :---------- |
| [ResourceManager](resource-ResourceManager.md) | Defines a container that stores resource objects  A resource object is an object that uses global configurations that can be shared across the project |
| [ResourceProvider](resource-ResourceProvider.md) | A resource provider that can be added to `im\resource\ResourceManager` |

## Classes
| Name | Description |
| :--- | :---------- |
| [TypedResourceManager](resource-TypedResourceManager.md) | An implementation of a `im\resource\ResourceManager`  This resource manager uses type safety by matching the resource objects against the identifiers |
