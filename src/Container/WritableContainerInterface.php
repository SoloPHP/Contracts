<?php

declare(strict_types=1);

namespace Solo\Contracts\Container;

use Psr\Container\ContainerInterface;

/**
 * Interface for containers that support service registration.
 *
 * Extends PSR-11 ContainerInterface with write capability.
 */
interface WritableContainerInterface extends ContainerInterface
{
    /**
     * Register a service in the container.
     *
     * @param string $id Service identifier
     * @param callable $factory Factory function that creates the service
     */
    public function set(string $id, callable $factory): void;
}
