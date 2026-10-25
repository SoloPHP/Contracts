<?php

declare(strict_types=1);

namespace Solo\Contracts\Router;

/**
 * Interface for router implementations.
 *
 * Minimal, framework-agnostic API
 *
 * @deprecated since 1.6, removed in 2.0. solophp/router 4 does not implement it and
 * solophp/application 4.0.1 does not use it: routes are registered on Solo\Router\RouteCollector
 * and requests resolved with Solo\Router\Router::resolve().
 */
interface RouterInterface
{
    /**
     * Adds a new route to the router.
     *
     * @param string $method HTTP method (GET, POST, etc.)
     * @param string $path Route path, without group prefix
     * @param callable|array{class-string, string}|string $handler Route handler (callable or controller reference)
     * @param array{
     *     group?: string,
     *     middlewares?: array<int, callable|string>,
     *     name?: string|null,
     *     attributes?: array<string, mixed>
     * } $options Middleware are callables or ids the caller resolves, e.g. class names
     */
    public function addRoute(
        string $method,
        string $path,
        callable|array|string $handler,
        array $options = []
    ): object;

    /**
     * Matches the requested method and URL against registered routes.
     *
     * Method names are case-sensitive (RFC 9110): "get" does not match a GET route.
     * Parameters are returned as they appear in $uri; decoding them is up to the caller.
     *
     * @param string $method HTTP method of the request
     * @param string $uri Requested URI path
     * @return array{
     *     handler: callable|array{class-string, string}|string,
     *     params: array<string, string>,
     *     middlewares: array<int, callable|string>,
     *     name?: string|null,
     *     attributes?: array<string, mixed>
     * }|false Middleware outermost first; name and attributes are optional for implementations
     */
    public function match(string $method, string $uri): array|false;
}
