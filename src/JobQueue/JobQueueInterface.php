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
     * Mark a job as failed and increment its retry counter.
     *
     * If the retry count exceeds the max retry limit, the job is marked as 'failed';
     * otherwise, it is returned to 'pending'.
     *
     * Passing a Throwable captures class/file/line in the error column and
     * lets implementations forward it under the PSR-3 'exception' key.
     *
     * @param int                          $jobId ID of the job
     * @param \Throwable|string            $error Throwable (preferred) or manual error message
     *
     * @return void
     */
    public function markFailed(int $jobId, \Throwable|string $error = ''): void;

    /**
     * Process pending jobs.
     *
     * @param int         $limit    Maximum number of jobs to process
     * @param string|null $onlyType If provided, only jobs with this type will be processed
     *
     * @return int Number of jobs actually executed (claimed and run)
     */
    public function processJobs(int $limit = 10, ?string $onlyType = null): int;

    /**
     * Return stuck jobs (locked_at older than the configured timeout) to pending,
     * or mark them failed if retries are exhausted. Useful as a separate cron
     * task; called automatically by processJobs() unless disabled.
     *
     * @return array{requeued: int, failed: int}
     */
    public function reclaimStuck(): array;

    /**
     * Retrieve permanently-failed jobs for inspection.
     *
     * @param int         $limit Maximum number of jobs to retrieve
     * @param string|null $type  If provided, only jobs with this type will be returned
     *
     * @return array<int, array<string, mixed>> Array of job records (status='failed')
     */
    public function getFailedJobs(int $limit = 50, ?string $type = null): array;

    /**
     * Re-queue a failed job: status returns to 'pending', retry_count is reset,
     * scheduled_at is set to now, error is cleared.
     *
     * @param int $jobId ID of the job
     *
     * @return bool True if a row was updated, false if the job did not exist
     */
    public function retry(int $jobId): bool;

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

    /**
     * Bulk-insert multiple jobs sharing the same type/schedule in a single statement.
     *
     * @param list<JobInterface>     $jobs        Jobs to enqueue
     * @param string|null            $type        Job type for filtering (optional)
     * @param DateTimeImmutable|null $scheduledAt When the jobs should be executed (default: now)
     * @param DateTimeImmutable|null $expiresAt   When the jobs become invalid (optional)
     *
     * @return int Number of jobs inserted
     */
    public function pushMany(
        array $jobs,
        ?string $type = null,
        ?DateTimeImmutable $scheduledAt = null,
        ?DateTimeImmutable $expiresAt = null
    ): int;

    /**
     * Return counts of jobs grouped by status. All four status keys are always
     * present (missing statuses default to 0). Filter by type when monitoring a
     * specific workload (use type as the grouping key for batch progress).
     *
     * @param string|null $type If provided, only jobs of this type are counted
     *
     * @return array{pending: int, in_progress: int, completed: int, failed: int}
     */
    public function getStats(?string $type = null): array;
}