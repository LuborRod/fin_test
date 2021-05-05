<?php

namespace App\Contracts\Services\TransferFunds;

use App\Contracts\DTO\Transaction\ITransactionData;

interface ITransferFundsService
{
    public function createOperation(ITransactionData $transactionData): void;
}
