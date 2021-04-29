<?php

namespace App\Repositories;


use App\Models\UsersTransaction;
use App\Repositories\Interfaces\UsersTransactionsRepositoryInterface;
use Carbon\Carbon;

class UsersTransactionsRepository implements UsersTransactionsRepositoryInterface
{
    private UsersTransaction $transaction;

    /**
     * @param UsersTransaction $usersTransaction
     */
    public function setTransaction(UsersTransaction $usersTransaction)
    {
        $this->transaction = $usersTransaction;
    }

    /**
     * @return UsersTransaction
     */
    public function getTransaction(): UsersTransaction
    {
        return $this->transaction;
    }


    /**
     * @param int $senderWalletId
     * @param int $receiverWalletId
     * @param int $amount
     * @param int $commissionPayer
     * @return UsersTransaction
     */
    public function createPendingTransaction(int $senderWalletId, int $receiverWalletId, int $amount, int $commissionPayer): UsersTransaction
    {
        $usersTransaction = new UsersTransaction();
        $usersTransaction->sender_wallet_id = $senderWalletId;
        $usersTransaction->receiver_wallet_id = $receiverWalletId;
        $usersTransaction->amount = $amount;
        $usersTransaction->date_created = Carbon::DEFAULT_TO_STRING_FORMAT;
        $usersTransaction->status = UsersTransaction::STATUS_PENDING;
        $usersTransaction->commission_payer = $commissionPayer;
        $usersTransaction->save();

        return $usersTransaction;
    }
}
