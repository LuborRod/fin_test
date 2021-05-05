<?php

namespace App\Repositories\SystemTransactions;

use App\Contracts\Repositories\SystemTransactions\ISystemTransactionsRepository;
use App\Models\SystemTransaction;

class SystemTransactionsRepository implements ISystemTransactionsRepository
{
    /**
     * @param int $userTransactionId
     * @param int $commission
     * @param int $currentBalance
     * @throws \Throwable
     */
    public function create(int $userTransactionId, int $commission, int $currentBalance): void
    {
        $systemTransaction = new SystemTransaction();
        $systemTransaction->user_transaction_id = $userTransactionId;
        $systemTransaction->amount = $commission;
        $systemTransaction->current_balance = $currentBalance + $systemTransaction->amount;
        $systemTransaction->saveOrFail();
    }

    /**
     * @return int
     */
    public function getCurrentBalance(): int
    {
        $objectSystemTransaction = SystemTransaction::orderBy('id', 'desc')->lockForUpdate()->first();

        return $objectSystemTransaction->current_balance ?? 0;
    }
}
