# SoloPHP Contracts

[![Latest Version on Packagist](https://img.shields.io/packagist/v/solophp/contracts.svg)](https://packagist.org/packages/solophp/contracts)
[![License](https://img.shields.io/packagist/l/solophp/contracts.svg)](https://github.com/solophp/contracts/blob/main/LICENSE)
[![PHP Version](https://img.shields.io/packagist/php-v/solophp/contracts.svg)](https://packagist.org/packages/solophp/contracts)

A collection of interfaces and contracts for the SoloPHP ecosystem. This package provides standardized contracts that enable interoperability between different SoloPHP components and allow developers to create custom implementations.

## Requirements

- PHP 8.1 or higher

## Installation

Install the package via Composer:

```bash
composer require solophp/contracts
```

## Available Contracts

### Router

**`RouterInterface`** - Framework-agnostic interface for HTTP routing implementations.

```php
use Solo\Contracts\Router\RouterInterface;

class MyRouter implements RouterInterface
{
    public function addRoute(string $method, string $path, $handler, array $options = []): void
    {
        // Your implementation
    }

    public function match(string $method, string $uri): array|false
    {
        // Your implementation
    }
}
```

### Job Queue

**`JobInterface`** - Interface for executable job classes.

```php
use Solo\Contracts\JobQueue\JobInterface;

class SendEmailJob implements JobInterface
{
    public function handle(): void
    {
        // Job execution logic
    }
}
```

**`JobQueueInterface`** - Interface for job queue implementations with support for scheduling, retries, and job processing.

```php
use Solo\Contracts\JobQueue\JobQueueInterface;

class DatabaseJobQueue implements JobQueueInterface
{
    public function push(JobInterface $job, ?string $type = null, ?DateTimeImmutable $scheduledAt = null, ?DateTimeImmutable $expiresAt = null): int
    {
        // Add job to queue
    }

    // Implement other methods: addJob, getPendingJobs, processJobs, markCompleted, markFailed
}
```

### Validator

**`ValidatorInterface`** - Interface for data validation implementations.

```php
use Solo\Contracts\Validator\ValidatorInterface;

class MyValidator implements ValidatorInterface
{
    public function validate(array $data, array $rules, array $messages = []): array
    {
        // Validation logic
        return $errors; // Empty array if valid
    }
}
```

## Usage

```json
{
    "require": {
        "solophp/contracts": "^1.0"
    }
}
```

## Benefits

- **Interoperability** - Components built on these contracts work together seamlessly
- **Flexibility** - Swap implementations without changing dependent code
- **Type Safety** - Strong typing ensures contract compliance
- **Framework Agnostic** - Use in any PHP project

## License

MIT