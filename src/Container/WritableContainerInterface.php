<?php

declare(strict_types=1);

namespace Solo\Contracts\Container;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Interface for containers that support service registration.
 *
 * Extends PSR-11 ContainerInterface with write capability. Services are shared:
 * the factory runs on the first get() of an id, and later calls return the same instance.
 */
interface WritableContainerInterface extends ContainerInterface
{
    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * An id that names a class or interface resolves to an instance of it: an
     * implementation throws a ContainerExceptionInterface rather than return
     * anything else. Any other id resolves to whatever was registered for it.
     *
     * @template T of object
     * @param class-string<T>|string $id Identifier of the entry to look for
     * @return ($id is class-string<T> ? T : mixed)
     * @throws NotFoundExceptionInterface No entry was found for this identifier
     * @throws ContainerExceptionInterface Error while retrieving the entry
     */
    public function get(string $id);

    /**
     * Register a service in the container.
     *
     * @param string $id Service identifier
     * @param callable(static): mixed $factory Factory function that creates the service; it receives the container
     */
    public function set(string $id, callable $factory): void;
}
