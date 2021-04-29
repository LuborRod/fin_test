<?php


namespace App\Services;


use App\Models\UsersTransaction;

class CalculationService
{
    const COMMISSION = 1.015;

    /**
     * @param int $amount
     * @return float
     */
    public function getCommissionFromAmount(int $amount): float
    {
        return round($amount * self::COMMISSION - $amount, 3);
    }


    /**
     * @param int $amount
     * @param float $commission
     * @return float|int
     */
    public function getSumOfAmountAndCommission(int $amount, float $commission)
    {
        return $amount + $commission;
    }

    /**
     * @param $balance
     * @param $writeOffSum
     * @return bool
     */
    public function ifEnoughFunds($balance, $writeOffSum): bool
    {
        return $balance >= $writeOffSum;
    }

    /**
     * @param int $commissionPayer
     * @param float $commission
     * @param $amount
     * @return array
     */
    public function getSumsForWriteOff(int $commissionPayer, float $commission, $amount): array
    {
        $sums = [];
        switch($commissionPayer) {
            case UsersTransaction::COMMISSION_PAYER_SENDER:
                $sums['sender'] = $this->getSumOfAmountAndCommission($amount, $commission);
                $sums['receiver'] = 0;
                break;
            case UsersTransaction::COMMISSION_PAYER_RECEIVER:
                $sums['sender'] = $amount;
                $sums['receiver'] = $commission;
                break;
        }

        return $sums;
    }
}
