<?php

namespace App\DTO;

use App\Models\UsersTransaction;

class TransactionDTO
{
    public string $senderWalletHash;
    public string $receiverWalletHash;
    public int $amount;
    public string $commissionPayer;

    public function __construct(string $senderWalletHash, string $receiverWalletHash, int $amount, $commissionPayer = UsersTransaction::COMMISSION_PAYER_SENDER)
    {
        $this->senderWalletHash = $senderWalletHash;
        $this->receiverWalletHash = $receiverWalletHash;
        $this->amount = $amount;
        $this->commissionPayer = $commissionPayer;
    }
}
