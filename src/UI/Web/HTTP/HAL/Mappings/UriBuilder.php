<?php
/**
 * PHP version 7.1
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */

namespace Ads\UI\Web\HTTP\HAL\Mappings;

interface UriBuilder
{
    public function pathFor(string $routeName, array $routeParameters, array $queryParameters = []): string;

    public function baseUri(): string;
}
