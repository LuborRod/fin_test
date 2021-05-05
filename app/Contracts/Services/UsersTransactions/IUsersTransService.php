<?php

namespace App\Contracts\Services\UsersTransactions;

use App\Models\UsersTransaction;

interface IUsersTransService
{
    public function createTransaction(int $senderWalletId, int $receiverWalletId, int $amount, int $commissionPayer): UsersTransaction;
}
