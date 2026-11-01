<?php

declare(strict_types=1);

namespace Solo\Contracts\JobQueue;

/**
 * Executes queued jobs. Type-hint it in workers and schedulers that only process work.
 */
interface JobProcessorInterface
{
    /**
     * Run maintenance once, then execute up to $limit ready jobs.
     *
     * @param int         $limit Maximum number of attempts to execute
     * @param string|null $type  If provided, only jobs with this type are executed
     *
     * @return int Number of attempts executed, never greater than $limit
     */
    public function processJobs(int $limit = 10, ?string $type = null): int;

    /**
     * Claim and execute one ready job without running maintenance.
     *
     * @param string|null $type If provided, only a job with this type is executed
     *
     * @return bool False when no job was ready
     */
    public function processNext(?string $type = null): bool;

    /**
     * Recover attempts abandoned by stopped workers and expire jobs past their deadline.
     *
     * @return array{requeued: int, failed: int, expired: int}
     */
    public function maintain(): array;
}
