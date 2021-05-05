<?php

namespace App\Services\Wallet;

use App\Contracts\Repositories\Wallet\IWalletRepository;
use App\Contracts\Services\Calculation\ICalculationService;
use App\Contracts\Services\Wallet\IWalletService;
use App\Models\Wallet;
use App\Services\BaseService;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class WalletService extends BaseService implements IWalletService
{
    private IWalletRepository $walletRepository;
    private ICalculationService $calculationService;

    public function __construct(IWalletRepository $walletRepository, ICalculationService $calculationService)
    {
        $this->walletRepository = $walletRepository;
        $this->calculationService = $calculationService;
    }


    /**
     * @param string $hash
     * @return mixed
     */
    public function getWalletByHash(string $hash)
    {
        return $this->walletRepository->getByHash($hash);
    }


    /**
     * @param Wallet $senderWallet
     * @param int $writeOffSum
     */
    public function checkSenderWalletForWriteOff(Wallet $senderWallet, int $writeOffSum): void
    {
        if (!$this->calculationService->ifEnoughFunds($senderWallet->current_balance, $writeOffSum)) {
            // Log Reason Somewhere
            throw new BadRequestHttpException('Sender don`t have enough funds for transfer');
        }
    }

    /**
     * @param Wallet $senderWallet
     * @param int $writeOffSum
     */
    public function chargeSumFromSender(Wallet $senderWallet, int $writeOffSum): void
    {
        $this->walletRepository->chargeSumSender($senderWallet, $writeOffSum);
    }

    /**
     * @param Wallet $receiverWallet
     * @param int $topUpSum
     */
    public function topUpSumToReceiver(Wallet $receiverWallet, int $topUpSum): void
    {
        $this->walletRepository->topUpSumReceiver($receiverWallet, $topUpSum);
    }
}
