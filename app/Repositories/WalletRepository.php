<?php

namespace App\Repositories;

use App\Models\Wallet;
use App\Repositories\Interfaces\WalletRepositoryInterface;

class WalletRepository implements WalletRepositoryInterface
{
    private array $wallets = [];

    /**
     * @param \App\Models\Wallet $wallet
     */
    public function setSender(Wallet $wallet)
    {
        $this->wallets['sender'] = $wallet;
    }


    /**
     * @return mixed
     */
    public function getSender()
    {
        return $this->wallets['sender'];
    }


    /**
     * @param \App\Models\Wallet $wallet
     */
    public function setReceiver(Wallet $wallet)
    {
        $this->wallets['receiver'] = $wallet;
    }


    /**
     * @return mixed
     */
    public function getReceiver()
    {
        return $this->wallets['receiver'];
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
    public function ifExists(string $hash): bool
    {
        return Wallet::where('hash', '=', $hash)->exists();
    }
}
