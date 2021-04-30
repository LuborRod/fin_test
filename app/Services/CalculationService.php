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
     * @param float $balance
     * @param $writeOffSum
     * @return bool
     */
    public function ifEnoughFunds(float $balance, $writeOffSum): bool
    {
        return $balance >= $writeOffSum;
    }

    /**
     * @param int $commissionPayer
     * @param float $commission
     * @param int $amount
     * @return array
     * @throws \Exception
     */
    public function getSumsForTransfer(int $commissionPayer, float $commission, int $amount): array
    {
        if (empty($commission)) {
            //Log somewhere
            throw new \Exception();
        }

        $sums = [];
        switch ($commissionPayer) {
            case UsersTransaction::COMMISSION_PAYER_SENDER:
                $sums['sender'] = $amount + $commission;
                $sums['receiver'] = $amount;
                break;
            case UsersTransaction::COMMISSION_PAYER_RECEIVER:
                $sums['sender'] = $amount;
                $sums['receiver'] = $amount - $commission;
                break;
            default:
                //Log somewhere
                throw new \Exception();
        }

        return $sums;
    }
}
