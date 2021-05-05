<?php

namespace App\Contracts\Services\Wallet;

use App\Models\Wallet;

interface IWalletService
{
    public function getWalletByHash(string $hash);

    public function checkSenderWalletForWriteOff(Wallet $senderWallet, int $writeOffSum): void;

    public function chargeSumFromSender(Wallet $senderWallet, int $writeOffSum): void;

    public function topUpSumToReceiver(Wallet $receiverWallet, int $topUpSum): void;
}
