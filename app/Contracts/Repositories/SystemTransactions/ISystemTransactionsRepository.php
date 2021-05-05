<?php

namespace App\Contracts\Repositories\SystemTransactions;

interface ISystemTransactionsRepository
{
    public function create(int $userTransactionId, int $commission, int $currentBalance): void;

    public function getCurrentBalance(): int;
}
