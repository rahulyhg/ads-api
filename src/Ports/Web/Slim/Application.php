<?php
/**
 * PHP version 7.1
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */

namespace Ads\Ports\Web\Slim;

use Ads\Ports\Web\Slim\Controllers\SignUpPosterController;
use Ads\Ports\Web\Slim\DependencyInjection\ApplicationServices;
use Ads\Ports\Web\Slim\Middleware\EventSubscribersMiddleware;
use Ads\Ports\Web\Slim\Middleware\RequestLoggerMiddleware;
use Slim\App;

class Application extends App
{
    public function __construct($options = [])
    {
        parent::__construct($options);
        $container = $this->getContainer();
        (new ApplicationServices($options))->register($container);

        $this->add($container[RequestLoggerMiddleware::class]);
        $this->add($container[EventSubscribersMiddleware::class]);

        $this->post('/posters', SignUpPosterController::class . ':signUp')
            ->setName('signUp');
        $this->get('/posters/{username}', SignUpPosterController::class . ':signUp')
            ->setName('poster');
    }
}
