<?php

declare(strict_types=1);

namespace Solo\Contracts\JobQueue;

/**
 * Interface for executable jobs
 */
interface JobInterface
{
    /**
     * Handle the job execution
     *
     * @return void
     */
    public function handle(): void;
}