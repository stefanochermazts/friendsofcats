<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'api/cats/*/like',
        'api/*',
        'sitemap.xml',
        'robots.txt',
    ];

    /**
     * Avoid setting XSRF cookie when there is no session available or for sitemap/robots routes.
     *
     * @param  SymfonyResponse  $response
     * @param  Request          $request
     * @return SymfonyResponse
     */
    protected function addCookieToResponse($response, $request)
    {
        if ($request instanceof Request) {
            if (!$request->hasSession() || $request->is('sitemap.xml') || $request->is('robots.txt')) {
                return $response;
            }
        }

        return parent::addCookieToResponse($response, $request);
    }
}