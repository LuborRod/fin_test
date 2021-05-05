<?php


namespace App\Contracts\DTO\Transaction;

interface ITransactionData
{
    public function create(string $senderWalletHash, string $receiverWalletHash, int $amount, ?int $commissionPayer): void;
}
