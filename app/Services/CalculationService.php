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
    public function getSumsForTransfer(int $commissionPayer, float $commission, $amount): array
    {
        $sums = [];
        switch($commissionPayer) {
            case UsersTransaction::COMMISSION_PAYER_SENDER:
                $sums['sender'] = $amount + $commission;
                $sums['receiver'] = $amount;
                break;
            case UsersTransaction::COMMISSION_PAYER_RECEIVER:
                $sums['sender'] = $amount;
                $sums['receiver'] = $amount - $commission;
                break;
        }

        return $sums;
    }
}
