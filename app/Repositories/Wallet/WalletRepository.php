<?php

namespace App\Repositories\Wallet;

use App\Contracts\Repositories\Wallet\IWalletRepository;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class WalletRepository implements IWalletRepository
{
    /**
     * @param string $hash
     * @return Wallet|Builder|Model|object|null
     */
    public function getByHash(string $hash)
    {
        return Wallet::where('hash', '=', $hash)->lockForUpdate()->first();
    }


    /**
     * @param string $hash
     * @return bool
     */
    public function ifExists(string $hash): bool
    {
        return Wallet::where('hash', '=', $hash)->exists();
    }


    /**
     * @param Wallet $senderWallet
     * @param $sum
     * @throws \Throwable
     */
    public function chargeSumSender(Wallet $senderWallet, $sum): void
    {
        $senderWallet->current_balance -= $sum;
        $senderWallet->saveOrFail();
    }


    /**
     * @param Wallet $receiverWallet
     * @param int $sum
     * @throws \Throwable
     */
    public function topUpSumReceiver(Wallet $receiverWallet, int $sum): void
    {
        $receiverWallet->current_balance += $sum;
        $receiverWallet->saveOrFail();
    }
}
