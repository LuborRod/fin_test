<?php

namespace App\Services\TransferFunds;

use App\Contracts\Services\Calculation\ICalculationService;
use App\Contracts\Services\Wallet\IWalletService;
use App\DTO\Transaction\TransactionData;
use App\DTO\TransferSums\TransferSumsData;
use App\Models\Wallet;
use App\Services\BaseService;
use App\Services\SystemTransactions\SystemTransService;
use App\Services\UsersTransactions\UsersTransService;
use Illuminate\Database\DatabaseManager as Db;
use Psr\Log\LoggerInterface;

class TransferFundsService extends BaseService
{
    private ICalculationService $calculationService;
    private SystemTransService $systemTransService;
    private UsersTransService $usersTransService;
    private IWalletService $walletService;
    private Db $db;
    private LoggerInterface $logger;

    public function __construct(
        UsersTransService $usersTransService,
        SystemTransService $systemTransService,
        ICalculationService $calculationService,
        IWalletService $walletService,
        Db $db,
        LoggerInterface $logger
    )
    {
        $this->usersTransService = $usersTransService;
        $this->systemTransService = $systemTransService;
        $this->calculationService = $calculationService;
        $this->walletService = $walletService;
        $this->db = $db;
        $this->logger = $logger;
    }

    /**
     * @param TransactionData $transactionData
     * @throws \Throwable
     */
    public function createOperation(TransactionData $transactionData): void
    {
        try {

            $this->db->beginTransaction();

            $senderWallet = $this->walletService->getWalletByHash($transactionData->getSenderWalletHash());
            $receiverWallet = $this->walletService->getWalletByHash($transactionData->getReceiverWalletHash());

            if ($senderWallet === null || $receiverWallet === null) {
                throw new \LogicException('Wallet is unavailable');
            }

            $this->calculationService->setAmountAndCommissionObjects($transactionData->getAmount());
            $transferSumsData = $this->calculationService->getSumsForTransfer($transactionData->getCommissionPayer());

            $this->walletService->checkSenderWalletForWriteOff($senderWallet, $transferSumsData->getSender());

            $this->transferFunds($senderWallet, $receiverWallet, $transferSumsData, $transactionData);

            $this->db->commit();

        } catch (\Exception $e) {
            $this->db->rollBack();
            $this->logger->alert($e->getMessage());
            throw $e;
        }
    }


    /**
     * @param Wallet $senderWallet
     * @param Wallet $receiverWallet
     * @param TransferSumsData $transferSums
     * @param TransactionData $transactionData
     * @throws \Throwable
     */
    private function transferFunds(Wallet $senderWallet, Wallet $receiverWallet, TransferSumsData $transferSums, TransactionData $transactionData): void
    {
        $this->walletService->chargeSumFromSender($senderWallet, $transferSums->getSender());

        $this->walletService->topUpSumToReceiver($receiverWallet, $transferSums->getReceiver());

        $userTransaction = $this->usersTransService->createTransaction(
            $senderWallet->id,
            $receiverWallet->id,
            $transactionData->getAmount(),
            $transactionData->getCommissionPayer(),
        );

        $this->systemTransService->createTransaction(
            $userTransaction->id,
            $transferSums->getCommission());
    }
}
