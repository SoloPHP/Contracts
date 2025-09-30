<?php

declare(strict_types=1);

namespace Solo\Contracts\JobQueue;

use DateTimeImmutable;

/**
 * Interface for job queue implementations
 */
interface JobQueueInterface
{
    /**
     * Add a job to the queue
     *
     * @param array<string, mixed>   $payload     Job data (must contain 'job_class' key)
     * @param DateTimeImmutable|null $scheduledAt When the job should be executed (default: now)
     * @param DateTimeImmutable|null $expiresAt   When the job becomes invalid (optional)
     * @param string|null            $type        Job type for filtering (optional)
     *
     * @return int ID of the newly inserted job
     */
    public function addJob(
        array $payload,
        ?DateTimeImmutable $scheduledAt = null,
        ?DateTimeImmutable $expiresAt = null,
        ?string $type = null
    ): int;

    /**
     * Retrieve pending jobs ready for execution
     *
     * @param int         $limit    Maximum number of jobs to retrieve
     * @param string|null $onlyType If provided, only jobs with this type will be returned
     *
     * @return array<array<string, mixed>> Array of job records
     */
    public function getPendingJobs(int $limit = 10, ?string $onlyType = null): array;

    /**
     * Mark a job as completed or delete it based on configuration
     *
     * @param int $jobId ID of the job
     *
     * @return void
     */
    public function markCompleted(int $jobId): void;

    /**
     * Mark a job as failed and increment its retry counter
     *
     * If the retry count exceeds the max retry limit, the job is marked as 'failed';
     * otherwise, it is returned to 'pending'.
     *
     * @param int    $jobId ID of the job
     * @param string $error Optional error message
     *
     * @return void
     */
    public function markFailed(int $jobId, string $error = ''): void;

    /**
     * Process pending jobs
     *
     * @param int         $limit    Maximum number of jobs to process
     * @param string|null $onlyType If provided, only jobs with this type will be processed
     *
     * @return void
     */
    public function processJobs(int $limit = 10, ?string $onlyType = null): void;

    /**
     * Push a job to the queue
     *
     * @param JobInterface $job Job instance
     * @param string|null $type Job type for filtering (optional)
     * @param DateTimeImmutable|null $scheduledAt When the job should be executed
     * @param DateTimeImmutable|null $expiresAt When the job becomes invalid
     *
     * @return int ID of the newly inserted job
     */
    public function push(
        JobInterface $job,
        ?string $type = null,
        ?DateTimeImmutable $scheduledAt = null,
        ?DateTimeImmutable $expiresAt = null
    ): int;
}