<?php
/**
 * PHP version 7.1
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */

namespace Ads\UI\Web\Slim;

use Ads\UI\Web\Slim\Controllers\DomainEventsController;
use Ads\UI\Web\Slim\Controllers\LoginController;
use Ads\UI\Web\Slim\Controllers\SignUpPosterController;
use Ads\UI\Web\Slim\Middleware\EventSubscribersMiddleware;
use Ads\UI\Web\Slim\Middleware\QueryLoggerMiddleware;
use Ads\UI\Web\Slim\Middleware\RequestLoggerMiddleware;
use Psr\Container\ContainerInterface;
use Slim\App;

class Application extends App
{
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);

        $this->add($container->get(RequestLoggerMiddleware::class));
        $this->add($container->get(EventSubscribersMiddleware::class));
        $this->add($container->get(QueryLoggerMiddleware::class));

        $this->post('/posters', SignUpPosterController::class . ':signUp')
            ->setName('signUp');
        $this->get('/posters/{username}', SignUpPosterController::class . ':signUp')
            ->setName('poster');

        $this->post('/authenticate', LoginController::class . ':authenticate')
            ->setName('authenticate');

        $this->get('/events', DomainEventsController::class . ':showPage')
            ->setName('events');
    }
}
