<?php

namespace App\Contracts\Services\SystemTransactions;

interface ISystemTransService
{
    public function createTransaction(int $userTransactionId, int $commission): void;
}
