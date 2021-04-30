<?php

namespace App\Services;

use App\Models\UsersTransaction;
use Carbon\Carbon;

class UsersTransService
{

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
        $usersTransaction = new UsersTransaction();
        $usersTransaction->sender_wallet_id = $senderWalletId;
        $usersTransaction->receiver_wallet_id = $receiverWalletId;
        $usersTransaction->amount = $amount;
        $usersTransaction->date_created = Carbon::now();
        $usersTransaction->commission_payer = $commissionPayer;
        $usersTransaction->saveOrFail();

        return $usersTransaction;
    }


}
