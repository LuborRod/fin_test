<?php

namespace App\Contracts\DTO\TransferSums;

interface ITransferSumsData
{
    public function create(int $sender, int $receiver, int $commission): void;
}
