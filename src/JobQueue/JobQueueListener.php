<?php

declare(strict_types=1);

namespace Solo\Contracts\JobQueue;

use Throwable;

/**
 * Observability hooks for a job queue. Implement to ship metrics (Datadog,
 * Prometheus), tracing spans (OpenTelemetry), or to enrich your own log
 * context (request id, tenant id) per job. All methods should be non-throwing:
 * exceptions raised in listeners propagate to the queue caller and may
 * interrupt job processing.
 */
interface JobQueueListener
{
    /**
     * Fired after a job row was claimed and its handler instantiated, just
     * before handle() runs. Use to open a tracing span or set log context.
     *
     * @param class-string $jobClass Concrete handler class name
     */
    public function onClaimed(int $jobId, string $jobClass): void;

    /**
     * Fired after a job completes successfully (markCompleted called).
     */
    public function onCompleted(int $jobId): void;

    /**
     * Fired after a job fails.
     *
     * @param Throwable|string $error     The exception (or manual string) that caused the failure
     * @param bool             $permanent True if retries are exhausted and the job is now in 'failed' status;
     *                                    false if it will be retried with backoff
     */
    public function onFailed(int $jobId, Throwable|string $error, bool $permanent): void;

    /**
     * Fired once per reclaim sweep when any rows were reclaimed. Counts are
     * aggregate because reclaim typically runs as a bulk UPDATE.
     */
    public function onReclaimed(int $requeuedCount, int $permanentlyFailedCount): void;
}
