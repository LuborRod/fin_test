<?php

namespace App\Contracts\Services\Calculation;

use App\Contracts\DTO\TransferSums\ITransferSumsData;

interface ICalculationService
{
    public function setAmountAndCommissionObjects(int $amount): void;

    public function getSumsForTransfer(int $commissionPayer): ITransferSumsData;

    public function ifEnoughFunds(int $balance, int $writeOffSum): bool;

    /**
     * @param $amountBtc int|float
     * @return int
     */
    public function convertBtcToSatoshi($amountBtc): int;
}
