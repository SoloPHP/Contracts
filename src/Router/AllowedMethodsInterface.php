<?php

declare(strict_types=1);

namespace Solo\Contracts\Router;

/**
 * Optional router capability: the methods a path is routed for.
 *
 * Lets callers answer 405 Method Not Allowed with an Allow header instead of 404 Not Found.
 */
interface AllowedMethodsInterface
{
    /**
     * Returns the HTTP methods that have a route matching the URI path, or an empty list
     * when no route matches it with any method.
     *
     * @param string $uri Requested URI path, in the same form as for RouterInterface::match()
     * @return list<string> e.g. ['GET', 'HEAD', 'POST']
     */
    public function getAllowedMethods(string $uri): array;
}
