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

/**
 * A resource provider that can be added to `im\resource\ResourceManager`.
 *
 * The purpose of a provider is to provide resources that can be configured
 * only when it's required. For an example a database resource can wait
 * until it's being requested, before it actually connects to a database server or
 * openes a database file.
 *
 * The `im\resource\ResourceManager` will also allow a provider to finalize
 * once it's no longer needed. For an example disconnecting a database connection,
 * or saving changes of some sorts to a file. 
 */
interface ResourceProvider {

    /**
     * This is called by `im\resource\ResourceManager` the first time
     * a resource is requested.
     *
     * It allows a resource provider to setup and configure the resource,
     * before serving it.
     *
     * @param $manager
     *      The `im\resource\ResourceManager` that called this method
     *
     * @param $identifier
     *      The identifier that was requested
     *
     * @param $args
     *      The arguments that was parsed when adding this provider to $manager
     *
     * @return
     *      Should return `TRUE` on success and `FALSE` if setup failed
     */
    function onConfigureResource(ResourceManager $manager, string $identifier, ...$args): bool;

    /**
     * This is called by `im\resource\ResourceManager` when it's being destroyed.
     *
     * It allows a resource provider to do some finalization before being shut down.
     *
     * @param $manager
     *      The `im\resource\ResourceManager` that called this method
     *
     * @param $identifier
     *      The identifier that is being terminated
     *
     * @return
     *      Should return `TRUE` on success and `FALSE` on failure
     */
    function onDestroyResource(ResourceManager $manager, string $identifier): bool;

    /**
     * This is called by `im\resource\ResourceManager` every time the resource is requested.
     *
     * @param $manager
     *      The `im\resource\ResourceManager` that called this method
     *
     * @param $identifier
     *      The identifier that is being requested
     *
     * @return
     *      A resource that is type match to the $identifier
     */
    function onRequestResource(ResourceManager $manager, string $identifier): object;
}
