<?php

declare(strict_types=1);

namespace Solo\Contracts\Validator;

interface ValidatorInterface
{
    /**
     * Validate data against rules
     *
     * @param array<string, mixed> $data Data to validate
     * @param array<string, string> $rules Validation rules ['field' => 'required|email']
     * @return array<string, list<array{rule: string, params?: string[]}>> Validation errors
     */
    public function validate(array $data, array $rules): array;
}