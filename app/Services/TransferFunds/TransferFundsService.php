<?php

namespace App\Services\TransferFunds;

use App\Contracts\DTO\Transaction\ITransactionData;
use App\Contracts\DTO\TransferSums\ITransferSumsData;
use App\Contracts\Services\Calculation\ICalculationService;
use App\Contracts\Services\SystemTransactions\ISystemTransService;
use App\Contracts\Services\TransferFunds\ITransferFundsService;
use App\Contracts\Services\UsersTransactions\IUsersTransService;
use App\Contracts\Services\Wallet\IWalletService;
use App\Models\Wallet;
use App\Services\BaseService;
use Illuminate\Database\DatabaseManager as Db;

class TransferFundsService extends BaseService implements ITransferFundsService
{
    private ICalculationService $calculationService;
    private ISystemTransService $systemTransService;
    private IUsersTransService $usersTransService;
    private IWalletService $walletService;
    private Db $db;

    public function __construct(
        IUsersTransService $usersTransService,
        ISystemTransService $systemTransService,
        ICalculationService $calculationService,
        IWalletService $walletService,
        Db $db
    )

    {
        $this->usersTransService = $usersTransService;
        $this->systemTransService = $systemTransService;
        $this->calculationService = $calculationService;
        $this->walletService = $walletService;
        $this->db = $db;
    }

    /**
     * @param ITransactionData $transactionData
     * @throws \Throwable
     */
    public function createOperation(ITransactionData $transactionData): void
    {
        $this->db->beginTransaction();

        try {
            $senderWallet = $this->walletService->getWalletByHash($transactionData->senderWalletHash);
            $receiverWallet = $this->walletService->getWalletByHash($transactionData->receiverWalletHash);

            if ($senderWallet === null || $receiverWallet === null) {
                // Log Reason Somewhere
                throw new \Exception();
            }

            $this->calculationService->setAmountAndCommissionObjects($transactionData->amount);
            $transferSumsData = $this->calculationService->getSumsForTransfer($transactionData->commissionPayer);

            $this->walletService->checkSenderWalletForWriteOff($senderWallet, $transferSumsData->sender);

            $this->transferFunds($senderWallet, $receiverWallet, $transferSumsData, $transactionData);

            $this->db->commit();

        } catch (\Exception $e) {
            $this->db->rollBack();
            // Log Reason Somewhere
            throw $e;
        }
    }


    /**
     * @param Wallet $senderWallet
     * @param Wallet $receiverWallet
     * @param ITransferSumsData $transferSums
     * @param ITransactionData $transactionData
     */
    private function transferFunds(Wallet $senderWallet, Wallet $receiverWallet, ITransferSumsData $transferSums, ITransactionData $transactionData): void
    {
        $this->walletService->chargeSumFromSender($senderWallet, $transferSums->sender);

        $this->walletService->topUpSumToReceiver($receiverWallet, $transferSums->receiver);

        $userTransaction = $this->usersTransService->createTransaction(
            $senderWallet->id,
            $receiverWallet->id,
            $transactionData->amount,
            $transactionData->commissionPayer,
        );

        $this->systemTransService->createTransaction(
            $userTransaction->id,
            $transferSums->commission);
    }
}
