<?php

namespace App\DTO;

use App\Models\UsersTransaction;

class TransactionDTO
{
    public string $senderWalletHash;
    public string $receiverWalletHash;
    public int $amount;
    public ?int $commissionPayer;

    public function __construct(string $senderWalletHash, string $receiverWalletHash, int $amount, $commissionPayer = null)
    {
        $this->senderWalletHash = $senderWalletHash;
        $this->receiverWalletHash = $receiverWalletHash;
        $this->amount = $amount;
        $this->commissionPayer = $commissionPayer ?? UsersTransaction::COMMISSION_PAYER_SENDER;
    }
}
