<?php

namespace App\Services;

use App\Models\Wallet;

class WalletService
{
    private Wallet $senderWallet;
    private Wallet $receiverWallet;

    /**
     * @param \App\Models\Wallet $wallet
     */
    public function setSender(Wallet $wallet): void
    {
        $this->senderWallet = $wallet;
    }


    /**
     * @return Wallet
     */
    public function getSender(): Wallet
    {
        return $this->senderWallet;
    }


    /**
     * @param \App\Models\Wallet $wallet
     */
    public function setReceiver(Wallet $wallet): void
    {
        $this->receiverWallet = $wallet;
    }


    /**
     * @return Wallet
     */
    public function getReceiver(): Wallet
    {
        return $this->receiverWallet;
    }


    /**
     * @param string $hash
     * @return Wallet|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getByHash(string $hash)
    {
        return Wallet::where('hash', '=', $hash)->first();
    }

    /**
     * @param string $hash
     * @return bool
     */
    public static function ifExists(string $hash): bool
    {
        return Wallet::where('hash', '=', $hash)->exists();
    }


    /**
     * @param $sum
     * @throws \Throwable
     */
    public function chargeSumSender($sum): void
    {
        $this->senderWallet->current_balance = $this->senderWallet->current_balance - $sum;
        $this->senderWallet->saveOrFail();
    }


    /**
     * @param $sum
     * @throws \Throwable
     */
    public function topUpSumReceiver($sum): void
    {
        $this->receiverWallet->current_balance = $this->receiverWallet->current_balance + $sum;
        $this->receiverWallet->saveOrFail();
    }
}
