<?php

namespace App\Rules;

use App\Models\UsersTransaction;
use Illuminate\Contracts\Validation\Rule;

class CommissionPayerRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return in_array($value, [UsersTransaction::COMMISSION_PAYER_SENDER, UsersTransaction::COMMISSION_PAYER_RECEIVER]);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Invalid value. Read DOCS';
    }
}
