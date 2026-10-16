<?php

declare(strict_types=1);

namespace Solo\Contracts\Container;

use Psr\Container\ContainerInterface;

/**
 * Interface for containers that support service registration.
 *
 * Extends PSR-11 ContainerInterface with write capability. Services are shared:
 * the factory runs on the first get() of an id, and later calls return the same instance.
 */
interface WritableContainerInterface extends ContainerInterface
{
    /**
     * Register a service in the container.
     *
     * @param string $id Service identifier
     * @param callable $factory Factory function that creates the service; it receives the container
     */
    public function set(string $id, callable $factory): void;
}
