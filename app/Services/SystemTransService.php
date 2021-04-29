<?php


namespace App\Services;


use App\Models\SystemTransaction;
use Illuminate\Database\Eloquent\Model;

class SystemTransService
{
    /**
     * @throws \Throwable
     */
    public function createTransaction(int $userTransactionId, $commission)
    {
        $currentBalance = $this->getCurrentBalance();

        $systemTransaction = new SystemTransaction();
        $systemTransaction->user_transaction_id = $userTransactionId;
        $systemTransaction->amount = $commission;
        $systemTransaction->current_balance = $currentBalance + $systemTransaction->amount;
        $systemTransaction->saveOrFail();
    }

    /**
     * @return int|mixed
     */
    private function getCurrentBalance()
    {
        $objectSystemTransaction = SystemTransaction::orderBy('id', 'desc')->first();

        return $objectSystemTransaction->current_balance ?? 0;
    }
}
