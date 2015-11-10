<?php

namespace DaMess\Test\Factory;

use Aura\Session\Session;
use DaMess\Factory\SessionMiddlewareFactory;
use DaMess\Http\SessionMiddleware;
use Interop\Container\ContainerInterface;

class SessionMiddlewareFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function setUp()
    {
        $this->container = $this->prophesize(ContainerInterface::class);
    }

    /**
     * @param SessionMiddleware $middleware
     * @return Session
     */
    public function fetchAuraSession(SessionMiddleware $middleware)
    {
        $r = new \ReflectionProperty($middleware, 'session');
        $r->setAccessible(true);
        return $r->getValue($middleware);
    }

    public function testInvokeFactory()
    {
        $factory = new SessionMiddlewareFactory();
        $middleware = $factory->__invoke($this->container->reveal());

        $this->assertInstanceOf(SessionMiddleware::class, $middleware);
    }

    public function testDefaultOptions()
    {
        $factory = new SessionMiddlewareFactory();
        $middleware = $factory->__invoke($this->container->reveal());
        $auraSession = $this->fetchAuraSession($middleware);

        $this->assertSame([
            'lifetime' => 7200,
            'path'     => null,
            'domain'   => null,
            'secure'   => false,
            'httponly' => true,
            'name'     => 'PHPSESSID',
        ], $auraSession->getCookieParams());
    }

    public function testCustomOptions()
    {
        $config = [
            'session' => [
                'lifetime' => 3600,
                'path'     => '/test',
                'domain'   => 'example.com',
                'secure'   => true,
                'httponly' => false,
                'name'     => 'DaMess',
            ],
        ];

        $factory = new SessionMiddlewareFactory();
        $this->container->get('config')->willReturn($config);
        $middleware = $factory->__invoke($this->container->reveal());
        $auraSession = $this->fetchAuraSession($middleware);

        $this->assertSame($config['session'], $auraSession->getCookieParams());
    }
}