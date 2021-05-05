<?php

namespace App\Services\UsersTransactions;

use App\Contracts\Repositories\UsersTransactions\IUsersTransactionsRepository;
use App\Contracts\Services\UsersTransactions\IUsersTransService;
use App\Models\UsersTransaction;
use App\Services\BaseService;

class UsersTransService extends BaseService implements IUsersTransService
{
    private IUsersTransactionsRepository $usersTransactionsRepository;

    public function __construct(IUsersTransactionsRepository $usersTransactionsRepository)
    {
        $this->usersTransactionsRepository = $usersTransactionsRepository;
    }


    /**
     * @param int $senderWalletId
     * @param int $receiverWalletId
     * @param int $amount
     * @param int $commissionPayer
     * @return UsersTransaction
     * @throws \Throwable
     */
    public function createTransaction(int $senderWalletId, int $receiverWalletId, int $amount, int $commissionPayer): UsersTransaction
    {
        return $this->usersTransactionsRepository->create($senderWalletId, $receiverWalletId, $amount, $commissionPayer);
    }


}
