<?php

namespace DaMess\Test\Factory;

use Aura\Session\Session;
use DaMess\Factory\AuraSessionFactory;
use DaMess\Http\SessionMiddleware;
use Interop\Container\ContainerInterface;

class AuraSessionFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function setUp()
    {
        $this->container = $this->prophesize(ContainerInterface::class);
    }

    public function testInvokeFactory()
    {
        $factory = new AuraSessionFactory();
        $session = $factory->__invoke($this->container->reveal());

        $this->assertInstanceOf(Session::class, $session);
    }

    public function testDefaultOptions()
    {
        $factory = new AuraSessionFactory();
        $session = $factory->__invoke($this->container->reveal());

        $this->assertSame([
            'lifetime' => 14400,
            'path'     => null,
            'domain'   => null,
            'secure'   => false,
            'httponly' => true,
            'name'     => 'PHPSESSID',
        ], $session->getCookieParams());
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

        $factory = new AuraSessionFactory();
        $this->container->get('config')->willReturn($config);
        $session = $factory->__invoke($this->container->reveal());

        $this->assertSame($config['session'], $session->getCookieParams());
    }
}
