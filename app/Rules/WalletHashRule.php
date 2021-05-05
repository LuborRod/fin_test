<?php

namespace App\Rules;

use App\Contracts\Repositories\Wallet\IWalletRepository;
use Illuminate\Contracts\Validation\Rule;

class WalletHashRule implements Rule
{

    private IWalletRepository $walletRepository;

    public function __construct(IWalletRepository $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }


    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return $this->walletRepository->ifExists($value);
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
