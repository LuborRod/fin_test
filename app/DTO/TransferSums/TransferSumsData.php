<?php

namespace App\DTO\TransferSums;


class TransferSumsData
{
    private int $receiver;
    private int $sender;
    private int $commission;

    public function create(int $sender, int $receiver, int $commission): void
    {
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->commission = $commission;
    }

    /**
     * @return int
     */
    public function getSender(): int
    {
        return $this->sender;
    }

    /**
     * @param int $sum
     */
    public function setSender(int $sum): void
    {
        $this->sender = $sum;
    }

    /**
     * @return int
     */
    public function getReceiver(): int
    {
        return $this->receiver;
    }

    /**
     * @param int $sum
     */
    public function setReceiver(int $sum): void
    {
        $this->receiver = $sum;
    }

    /**
     * @return int
     */
    public function getCommission(): int
    {
        return $this->commission;
    }

    /**
     * @param int $sum
     */
    public function setCommission(int $sum)
    {
        $this->commission = $sum;
    }
}
