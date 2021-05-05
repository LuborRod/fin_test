<?php

namespace App\DTO\Transaction;

use App\Contracts\DTO\Transaction\ITransactionData;
use App\Models\UsersTransaction;

class TransactionData implements ITransactionData
{
    public string $senderWalletHash;
    public string $receiverWalletHash;
    public int $amount;
    public ?int $commissionPayer;

    public function create(string $senderWalletHash, string $receiverWalletHash, int $amount, ?int $commissionPayer): void
    {
        $this->senderWalletHash = $senderWalletHash;
        $this->receiverWalletHash = $receiverWalletHash;
        $this->amount = $amount;
        $this->commissionPayer = $commissionPayer ?? UsersTransaction::COMMISSION_PAYER_SENDER;
    }
}
