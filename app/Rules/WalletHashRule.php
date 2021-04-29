<?php

namespace App\Rules;

use App\Repositories\Interfaces\WalletRepositoryInterface;
use Illuminate\Contracts\Validation\Rule;

class WalletHashRule implements Rule
{
    private WalletRepositoryInterface $walletRepository;

    public function __construct(WalletRepositoryInterface $walletRepository)
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
