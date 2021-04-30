<?php


namespace App\Services;


use App\Models\UsersTransaction;
use Money\Currency;
use Money\Money;

class CalculationService
{
    const COMMISSION = 1.015;

    private Money $amount;
    private Money $commission;


    /**
     * @param int $amount
     */
    public function setAmountAndCommissionObjects(int $amount): void
    {
        $this->amount = new Money($amount, new Currency('XBT'));

        $amountWithCommission = $this->amount->multiply(self::COMMISSION);

        $this->commission = $amountWithCommission->subtract($this->amount);
    }


    /**
     * @param int $commissionPayer
     * @return array
     * @throws \Exception
     */
    public function getSumsForTransfer(int $commissionPayer): array
    {
        $sums = [];
        switch ($commissionPayer) {
            case UsersTransaction::COMMISSION_PAYER_SENDER:
                $sums['sender'] = (int)$this->amount->add($this->commission)->getAmount();
                $sums['receiver'] = (int)$this->amount->getAmount();
                break;
            case UsersTransaction::COMMISSION_PAYER_RECEIVER:
                $sums['sender'] = (int)$this->amount->getAmount();;
                $sums['receiver'] = (int)$this->amount->subtract($this->commission)->getAmount();
                break;
            default:
                //Log somewhere
                throw new \Exception();
        }

        $sums['commission'] = (int)$this->commission->getAmount();

        return $sums;
    }

    /**
     * @param int $balance
     * @param int $writeOffSum
     * @return bool
     */
    public function ifEnoughFunds(int $balance, int $writeOffSum): bool
    {
        return $balance >= $writeOffSum;
    }
}
