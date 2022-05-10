<?php declare(strict_types=1);
/*
 * This file is part of the IMPHP Project: https://github.com/IMPHP
 *
 * Copyright (c) 2022 Daniel Bergløv, License: MIT
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software
 * and associated documentation files (the "Software"), to deal in the Software without restriction,
 * including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO
 * THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR
 * THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace im\resource;

use stdClass;
use Exception;
use im\util\Map;
use im\util\MutableMappedArray;
use im\util\LIFOStack;
use im\util\Stackable;

/**
 * An implementation of a `im\resource\ResourceManager`
 *
 * This resource manager uses type safety by matching the resource
 * objects against the identifiers. As such, the identifiers used with this manager
 * is strictly forced to be the name of the objects class or one of it's parents.
 */
class TypedResourceManager implements ResourceManager {

    /** @internal */
    const TYPE_PENDING = 0;

    /** @internal */
    const TYPE_PROVIDER = 1;

    /** @internal */
    const TYPE_OBJECT = 2;

    /** @internal */
    const TYPE_ALIAS = 3;

    /** @internal */
    protected MutableMappedArray $providers;

    /** @internal */
    protected Stackable $running;

    /**
     *
     */
    public function __construct() {
        $this->providers = new Map();
        $this->running = new LIFOStack();
    }

    /**
     * Point an alias to another identifier
     *
     * The alias itself must also be either the name of the object class
     * or a parent class or interface.
     *
     * @example
     *      ```
     *      <?php
     *      interface Database {}
     *      class MySQL implements Database {}
     *
     *      $manager = new TypedResourceManager();
     *      $manager->setResource("MySQL", new MySQL());
     *      $manager->setResourceAlias("Database", "MySQL");
     *      ```
     *
     * @param $alias
     *      An alias
     *
     * @param $identifier
     *      The actual identifyer that the alias points to
     */
    public function setResourceAlias(string $alias, string $identifier): void {
        if (!$this->providers->isset($identifier)) {
            throw new Exception("Cannot alias from '$alias' to '$identifier', no such resource was found");

        } else if ($this->providers->isset($alias)) {
            throw new Exception("The resource '$alias' already exists");
        }

        $res = new stdClass();
        $res->type = static::TYPE_ALIAS;
        $res->identifier = $alias;
        $res->data = $identifier;

        $this->providers->set($alias, $res);
    }

    /**
     * Set a resource provider for a specific identifier
     *
     * A resource provider is not the actual resource, but a `class` or `callable` that
     * provides the resource when it's requested.
     *
     * @note
     *      A callable is only called ones. After the initial call, the object returned
     *      will be cached for future calls.
     *
     * @example
     *      ```
     *      <?php
     *      $manager = new TypedResourceManager();
     *      $manager->setResourceProvider("SomeResource", function(ResourceManager $manager, string $identifier, ...$args){
     *          return new SomeResource();
     *      });
     *
     *      $resource = $manager->getResource("SomeResource");
     *      ```
     *
     * @param $identifier
     *      The resource identifier
     *
     * @param $provider
     *      The resource provider
     *
     * @param $args
     *      Additional arguments that will be passed to the initial call to the provider
     */
    public function setResourceProvider(string $identifier, ResourceProvider|callable $provider, ...$args): void {
        if ($this->providers->isset($identifier)) {
            throw new Exception("The resource '$identifier' already exists");
        }

        $res = new stdClass();
        $res->type = static::TYPE_PENDING;
        $res->identifier = $identifier;
        $res->data = $provider;
        $res->args = $args;

        $this->providers->set($identifier, $res);
    }

    /**
     * Set a resource for a specific identifier
     *
     * The object passed to this method should be the actual resource object
     * and it's type must be a match to the identifier.
     *
     * @param $identifier
     *      The resource identifier
     *
     * @param $provider
     *      The actual resource object
     */
    public function setResource(string $identifier, object $provider): void {
        if (!($provider instanceof ($identifier))) {
            throw new Exception("The resource for '$identifier' must be a type match");

        } else if ($this->providers->isset($identifier)) {
            throw new Exception("The resource '$identifier' already exists");
        }

        $res = new stdClass();
        $res->type = static::TYPE_OBJECT;
        $res->identifier = $identifier;
        $res->data = $provider;

        $this->providers->set($identifier, $res);
    }

    /**
     * @inheritDoc
     */
    #[Override("im\resource\ResourceManager")]
    public function hasResource(string $identifier): bool {
        return $this->providers->isset($identifier);
    }

    /**
     * @inheritDoc
     */
    #[Override("im\resource\ResourceManager")]
    public function getResource(string $identifier): object { // object<$identifier>
        $res = $this->providers->get($identifier);

        if ($res == NULL) {
            throw new Exception("Could not find any resource matching '$identifier'");

        } else if ($res->type == static::TYPE_ALIAS) {
            $obj = $this->getResource($res->data);

        } else if ($res->type == static::TYPE_PENDING
                    && $res->data instanceof ResourceProvider) {

            if ($res->data->onConfigureResource($this, $identifier, ...($res->args))) {
                $res->type = static::TYPE_PROVIDER;
                $this->running->push($identifier);

                $obj = $res->data->onRequestResource($this, $identifier);

            } else {
                throw new Exception("Failed to configure resource '$identifier'");
            }

        } else if ($res->type == static::TYPE_PENDING
                    && is_callable($res->data)) {

            $obj = ($res->data)($this, $identifier, ...($res->args));

            if (is_object($obj)) {
                $res->data = $obj;
                $res->type = static::TYPE_OBJECT;

            } else {
                throw new Exception("Failed to configure resource '$identifier'");
            }

        } else if ($res->type == static::TYPE_OBJECT) {
            $obj = $res->data;

        } else if ($res->type == static::TYPE_PROVIDER) {
            $obj = $res->data->onRequestResource($this, $identifier);

        } else {
            throw new Exception("Failed to identify the resource type of '$identifier'");
        }

        if (!($obj instanceof ($identifier))) {
            throw new Exception("The resource provided for '$identifier' does not match the requested type");
        }

        return $obj;
    }

    /**
     * Destroy this entire instance
     *
     * This will clear all of the resources within this inctance, but
     * only after it has deinitialized all of the `im\resource\ResourceProvider` instances. 
     */
    public function destroy(): void {
        while (($identifier = $this->running->pop()) != NULL) {
            $res = $this->providers->get($identifier);

            if (!$res->data->onDestroyResource($this, $identifier)) {
                throw new Exception("Failed to cleanup resource '$identifier'");
            }

            $res->type = static::TYPE_PENDING;
        }

        $this->providers->clear();
    }
}
