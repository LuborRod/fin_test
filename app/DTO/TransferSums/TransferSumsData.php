<?php

namespace App\DTO\TransferSums;

use App\Contracts\DTO\TransferSums\ITransferSumsData;

class TransferSumsData implements ITransferSumsData
{
    public int $receiver;
    public int $sender;
    public int $commission;

    public function create(int $sender, int $receiver, int $commission): void
    {
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->commission = $commission;
    }
}
