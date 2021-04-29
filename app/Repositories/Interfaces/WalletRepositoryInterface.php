<?php

namespace App\Repositories\Interfaces;

use App\Models\Wallet;

interface WalletRepositoryInterface
{
    public function setSender(Wallet $wallet);
    public function getSender();
    public function setReceiver(Wallet $wallet);
    public function getReceiver();
    public function getByHash(string $hash);
    public function IfExists(string $hash);
}
