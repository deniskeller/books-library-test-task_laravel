<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NoHtmlTags implements ValidationRule
{
    protected ?string $customName;

    public function __construct(?string $customName = null)
    {
        $this->customName = $customName;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (preg_match('/<[^>]*>/', $value)) {
            $fieldName = $this->customName ?? $attribute;
            $fail("Поле '{$fieldName}' не должно содержать HTML-теги");
        }
    }
}
