<?php

declare(strict_types=1);

namespace Solo\Contracts\JobQueue;

use DateTimeImmutable;

/**
 * Enqueues jobs. Type-hint it in services that only schedule work.
 */
interface JobProducerInterface
{
    /**
     * Store a job for later execution.
     *
     * @param JobInterface           $job         Job instance
     * @param string|null            $type        Job type consumers can filter by; null selects the default type
     * @param DateTimeImmutable|null $scheduledAt Earliest execution time (default: now)
     * @param DateTimeImmutable|null $expiresAt   Deadline after which the job no longer runs (optional)
     *
     * @return int ID of the stored job
     */
    public function push(
        JobInterface $job,
        ?string $type = null,
        ?DateTimeImmutable $scheduledAt = null,
        ?DateTimeImmutable $expiresAt = null
    ): int;

    /**
     * Store several jobs sharing the same type, schedule and deadline.
     *
     * @param list<JobInterface>     $jobs        Jobs to enqueue
     * @param string|null            $type        Job type consumers can filter by; null selects the default type
     * @param DateTimeImmutable|null $scheduledAt Earliest execution time (default: now)
     * @param DateTimeImmutable|null $expiresAt   Deadline after which the jobs no longer run (optional)
     *
     * @return int Number of stored jobs
     */
    public function pushMany(
        array $jobs,
        ?string $type = null,
        ?DateTimeImmutable $scheduledAt = null,
        ?DateTimeImmutable $expiresAt = null
    ): int;
}
