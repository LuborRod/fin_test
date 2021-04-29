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
        $permittedCommissionPayers = array_values(UsersTransaction::COMMISSION_PAYERS);

        return in_array($value, $permittedCommissionPayers);
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
