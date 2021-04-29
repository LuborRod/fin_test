<?php

namespace App\Rules;

use App\Models\Wallet;
use Illuminate\Contracts\Validation\Rule;

class WalletHashRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return Wallet::where('hash', '=', $value)->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Invalid hash';
    }
}
