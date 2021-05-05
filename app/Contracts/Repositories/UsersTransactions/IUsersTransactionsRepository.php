<?php

namespace App\Contracts\Repositories\UsersTransactions;

use App\Models\UsersTransaction;

interface IUsersTransactionsRepository
{
    public function create(int $senderWalletId, int $receiverWalletId, int $amount, int $commissionPayer): UsersTransaction;
}
