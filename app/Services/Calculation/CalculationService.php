<?php


namespace App\Services\Calculation;

use App\Contracts\Services\Calculation\ICalculationService;
use App\DTO\TransferSums\TransferSumsData;
use App\Models\UsersTransaction;
use App\Services\BaseService;
use Money\Currency;
use Money\Money;

class CalculationService extends BaseService implements ICalculationService
{
    private const COMMISSION = 1.015;
    private const FORMAT_BTC_TO_SATOSHI = 100000000;

    private Money $amount;
    private Money $commission;
    private TransferSumsData $transferSumsData;


    public function __construct(TransferSumsData $transferSumsData)
    {
        $this->transferSumsData = $transferSumsData;
    }


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
     * @return TransferSumsData
     * @throws \Exception
     */
    public function getSumsForTransfer(int $commissionPayer): TransferSumsData
    {
        switch ($commissionPayer) {
            case UsersTransaction::COMMISSION_PAYER_SENDER:
                $this->transferSumsData->create(
                    (int)$this->amount->add($this->commission)->getAmount(),
                    (int)$this->amount->getAmount(),
                    (int)$this->commission->getAmount()
                );
                break;
            case UsersTransaction::COMMISSION_PAYER_RECEIVER:
                $this->transferSumsData->create(
                    (int)$this->amount->getAmount(),
                    (int)$this->amount->subtract($this->commission)->getAmount(),
                    (int)$this->commission->getAmount()
                );
                break;
            default:
                throw new \LogicException('Commission payer is undetermined');
        }

        return $this->transferSumsData;
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


    /**
     * @param $amountBtc int|float
     * @return int
     */
    public function convertBtcToSatoshi($amountBtc): int
    {
        return (int)($amountBtc * self::FORMAT_BTC_TO_SATOSHI);
    }
}
