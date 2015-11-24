<?php

namespace DaMess\Http;

use Aura\Session\Session;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class SessionMiddleware
{
    /**
     * @var Session
     */
    protected $session;

    /**
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable|null $next
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        if (!$this->session->isStarted()) {
            $this->session->start();
        }

        $request = $request->withAttribute('session', $this->session);

        if ($next) {
            return $next($request, $response);
        }

        return $response;
    }
}
