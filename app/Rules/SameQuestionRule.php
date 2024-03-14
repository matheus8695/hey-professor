<?php

namespace App\Rules;

use App\Models\Question;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SameQuestionRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->validateRule($value)) {
            $fail('Pergunta já existe!');
        }
    }

    private function validateRule(string $value): bool
    {
        return Question::whereQuestion($value)->exists();
    }
}
