<?php

namespace DaMess\Factory;

use Aura\Session\Session;
use DaMess\Http\SessionMiddleware;
use Interop\Container\ContainerInterface;

class SessionMiddlewareFactory
{
    /**
     * @param ContainerInterface $container
     */
    public function __invoke(ContainerInterface $container)
    {
        return new SessionMiddleware($container->get(Session::class));
    }
}
