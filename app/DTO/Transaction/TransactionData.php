<?php

namespace App\DTO\Transaction;

use App\Models\UsersTransaction;

/**
 * @OA\Schema(@OA\Xml(name="TransactionData"))
 */
class TransactionData
{
    /**
     * @OA\Property()
     * @var string
     */
    private string $senderWalletHash;
    /**
     * @OA\Property()
     * @var string
     */
    private string $receiverWalletHash;
    /**
     * @OA\Property()
     * @var int|float
     */
    private int $amount;
    /**
     * @OA\Property()
     * @var int
     */
    private ?int $commissionPayer;

    public function create(string $senderWalletHash, string $receiverWalletHash, int $amount, ?int $commissionPayer): void
    {
        $this->senderWalletHash = $senderWalletHash;
        $this->receiverWalletHash = $receiverWalletHash;
        $this->amount = $amount;
        $this->commissionPayer = $commissionPayer ?? UsersTransaction::COMMISSION_PAYER_SENDER;
    }


    /**
     * @return string
     */
    public function getSenderWalletHash(): string
    {
        return $this->senderWalletHash;
    }


    /**
     * @param string $hash
     */
    public function setSenderWalletHash(string $hash): void
    {
        $this->senderWalletHash = $hash;
    }


    /**
     * @return string
     */
    public function getReceiverWalletHash(): string
    {
        return $this->receiverWalletHash;
    }

    /**
     * @param string $hash
     */
    public function setReceiverWalletHash(string $hash): void
    {
        $this->receiverWalletHash = $hash;
    }


    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }


    /**
     * @param int $amount
     */
    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }


    /**
     * @return int|null
     */
    public function getCommissionPayer(): ?int
    {
        return $this->commissionPayer;
    }


    /**
     * @param int $commissionPayer
     */
    public function setCommissionPayer(int $commissionPayer): void
    {
        $this->commissionPayer = $commissionPayer;
    }
}
