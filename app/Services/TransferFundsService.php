<?php


namespace App\Services;

use App\DTO\TransactionDTO;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class TransferFundsService
{
    const FORMAT_BTC_TO_SATOSHI = 100000000;

    private CalculationService $calculationService;
    private SystemTransService $systemTransService;
    private UsersTransService $usersTransService;
    private WalletService $walletService;

    // Here in real life we can have to use interfaces.And then in custom service_providers to bind dependencies.
    public function __construct(
        UsersTransService $usersTransService,
        SystemTransService $systemTransService,
        CalculationService $calculationService,
        WalletService $walletService
    )
    {
        $this->usersTransService = $usersTransService;
        $this->systemTransService = $systemTransService;
        $this->calculationService = $calculationService;
        $this->walletService = $walletService;
    }

    /**
     * @param TransactionDTO $transactionDTO
     * @throws \Throwable
     */
    public function createOperation(TransactionDTO $transactionDTO): void
    {
        DB::beginTransaction();

        try {
            $senderWallet = $this->walletService->getByHash($transactionDTO->senderWalletHash);
            $receiverWallet = $this->walletService->getByHash($transactionDTO->receiverWalletHash);

            $this->walletService->setSender($senderWallet);
            $this->walletService->setReceiver($receiverWallet);

            $this->calculationService->setAmountAndCommissionObjects($transactionDTO->amount);
            $transferSums = $this->calculationService->getSumsForTransfer($transactionDTO->commissionPayer);

            $this->checkSenderBalanceForWriteOff($transferSums['sender']);

            $this->transferFunds($transferSums, $transactionDTO);

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            // Log Reason Somewhere
            throw $e;
        }
    }

    /**
     * @param $senderSum
     * @throws \Exception
     */
    private function checkSenderBalanceForWriteOff($senderSum): void
    {
        $senderWallet = $this->walletService->getSender();
        if (empty($senderWallet)) {
            //Log Reason somewhere
            throw new \Exception();
        }
        if (!$this->calculationService->ifEnoughFunds($senderWallet->current_balance, $senderSum)) {
            // Log Reason Somewhere
            throw new BadRequestHttpException('Sender don`t have enough funds for transfer');
        }
    }


    /**
     * @throws \Throwable
     */
    private function transferFunds(array $transferSums, TransactionDTO $transactionDTO): void
    {
        $this->walletService->chargeSumSender($transferSums['sender']);

        $this->walletService->topUpSumReceiver($transferSums['receiver']);

        $userTransaction = $this->usersTransService->createTransaction(
            $this->walletService->getSenderId(),
            $this->walletService->getReceiverId(),
            $transactionDTO->amount,
            $transactionDTO->commissionPayer,
        );

        $this->systemTransService->createTransaction(
            $userTransaction->id,
            $transferSums['commission']);
    }


}
