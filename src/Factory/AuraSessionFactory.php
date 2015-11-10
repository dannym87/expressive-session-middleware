<?php

namespace DaMess\Factory;

use Aura\Session\SessionFactory;
use Interop\Container\ContainerInterface;

class AuraSessionFactory
{
    /**
     * @var array
     */
    protected $options = [
        'name'     => 'PHPSESSID',
        'lifetime' => 7200,
        'path'     => null,
        'domain'   => null,
        'secure'   => false,
        'httponly' => true,
    ];

    /**
     * @param ContainerInterface $container
     */
    public function __invoke(ContainerInterface $container)
    {
        $auraSession = (new SessionFactory())->newInstance($_COOKIE);
        $config = $container->get('config');
        $sessionConfig = array_merge($this->options, isset($config['session']) ? $config['session'] : []);

        $auraSession->setCookieParams($sessionConfig);
        $auraSession->setName($sessionConfig['name']);

        return $auraSession;
    }
}
