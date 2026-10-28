<?php

declare(strict_types=1);

namespace Solo\Contracts\Validator;

/**
 * Validates data against rule strings.
 *
 * A field missing from the data, or `null` in it, has no value: only the rules
 * that decide whether a value is needed — such as `required`, `filled`,
 * `present` or `required_if` — check it. Any other value, `''` and `[]`
 * included, goes through all of the field's rules, unless its rules say
 * otherwise.
 */
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