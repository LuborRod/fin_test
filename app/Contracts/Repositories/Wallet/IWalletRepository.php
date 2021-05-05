<?php

namespace App\Contracts\Repositories\Wallet;

use App\Models\Wallet;

interface IWalletRepository
{
    public function getByHash(string $hash);

    public function ifExists(string $hash): bool;

    public function chargeSumSender(Wallet $senderWallet, int $sum): void;

    public function topUpSumReceiver(Wallet $receiverWallet, int $sum): void;
}
