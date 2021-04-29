<?php

namespace App\Services;

use App\Models\UsersTransaction;
use Carbon\Carbon;

class UsersTransService
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
     * @return int
     */
    public function getTransactionId(): int
    {
        return $this->getTransaction()->id;
    }


    public function setFailed()
    {
        $this->getTransaction()->status = UsersTransaction::STATUS_FAILED;
        $this->getTransaction()->save();
    }

    public function setSuccess()
    {
        $this->getTransaction()->status = UsersTransaction::STATUS_SUCCESS;
        $this->getTransaction()->save();
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
        $usersTransaction->date_created = Carbon::now();
        $usersTransaction->status = UsersTransaction::STATUS_PENDING;
        $usersTransaction->commission_payer = $commissionPayer;
        $usersTransaction->save();

        return $usersTransaction;
    }


}
