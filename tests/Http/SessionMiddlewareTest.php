<?php

namespace DaMess\Test\Http;

use Aura\Session\Session;
use DaMess\Http\SessionMiddleware;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Request;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;

class SessionMiddlewareTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Session
     */
    protected $session;

    public function setUp()
    {
        $this->session = $this->prophesize(Session::class);
    }

    public function testSessionStarts()
    {
        $next = function(ServerRequestInterface $request) {
            $this->assertInstanceOf(Session::class, $request->getAttribute(SessionMiddleware::KEY));
        };

        $this->session->isStarted()->shouldBeCalled();
        $this->session->start()->shouldBeCalled();
        $middleware = new SessionMiddleware($this->session->reveal());
        $middleware->__invoke(new ServerRequest(), new Response(), $next);
    }
}