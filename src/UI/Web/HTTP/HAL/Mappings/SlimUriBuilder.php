<?php
/**
 * PHP version 7.1
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */

namespace Ads\UI\Web\HTTP\HAL\Mappings;

use Slim\Http\Request;
use Slim\Router;

class SlimUriBuilder implements UriBuilder
{
    /** @var Router */
    private $router;

    /** @var Request */
    private $request;

    public function __construct(Router $router, Request $request)
    {
        $this->router = $router;
        $this->request = $request;
    }

    public function pathFor(string $routeName, array $routeParameters = [], array $queryParameters = []): string
    {
        return (string)$this->request->getUri()
            ->withPath($this->router->pathFor($routeName, $routeParameters))
            ->withQuery(http_build_query($queryParameters));
    }

    public function baseUri(): string
    {
        return $this->request->getUri()->withPath('');
    }
}
