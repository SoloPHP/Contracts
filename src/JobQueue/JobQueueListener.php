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
     * Fired after a job was claimed and its handler instantiated, before
     * handle() runs. Use to open a tracing span or set log context.
     *
     * @param class-string $jobClass Concrete handler class name
     */
    public function onClaimed(int $jobId, string $jobClass): void;

    /**
     * Fired after a job completed successfully and the queue recorded it.
     */
    public function onCompleted(int $jobId): void;

    /**
     * Fired after a failed attempt was recorded.
     *
     * @param Throwable|string $error     The exception (or manual string) that caused the failure
     * @param bool             $permanent True if the job will not run again automatically (attempts exhausted
     *                                    or deadline passed); false if it was rescheduled with backoff
     */
    public function onFailed(int $jobId, Throwable|string $error, bool $permanent): void;

    /**
     * Fired once per maintenance run that recovered attempts abandoned by stopped
     * workers. $permanentlyFailedCount counts recovered jobs that will not run
     * again: attempts exhausted or deadline passed.
     */
    public function onReclaimed(int $requeuedCount, int $permanentlyFailedCount): void;
}
