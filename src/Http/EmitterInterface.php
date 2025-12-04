<?php

declare(strict_types=1);

namespace Solo\Contracts\Http;

use Psr\Http\Message\ResponseInterface;

/**
 * Interface for HTTP response emitters.
 */
interface EmitterInterface
{
    /**
     * Emit a PSR-7 response.
     *
     * @param ResponseInterface $response The response to emit
     */
    public function emit(ResponseInterface $response): void;
}
