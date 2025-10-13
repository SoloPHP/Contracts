<?php

declare(strict_types=1);

namespace Solo\Contracts\Router;

/**
 * Interface for router implementations.
 *
 * Minimal, framework-agnostic API
 */
interface RouterInterface
{
    /**
     * Adds a new route to the router.
     *
     * @param string $method HTTP method (GET, POST, etc.)
     * @param string $path Route path, without group prefix
     * @param callable|array|string $handler Route handler (callable or controller reference)
     * @param array{group?:string,middlewares?:array<int,callable>,name?:string} $options
     */
    public function addRoute(
        string $method,
        string $path,
        callable|array|string $handler,
        array $options = []
    ): void;

    /**
     * Matches the requested method and URL against registered routes.
     *
     * @param string $method HTTP method of the request
     * @param string $uri Requested URI
     * @return array{handler:callable|array|string,params:array<string,string>,middlewares:array<int,callable>}|false
     */
    public function match(string $method, string $uri): array|false;
}
