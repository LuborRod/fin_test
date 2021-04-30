<?php


namespace App\Services;

use App\DTO\TransactionDTO;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class TransferFundsService
{
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
    public function createOperation(TransactionDTO $transactionDTO)
    {
        $commission = $this->calculationService->getCommissionFromAmount($transactionDTO->amount);

        $senderWallet = $this->walletService->getByHash($transactionDTO->senderWalletHash);
        $receiverWallet = $this->walletService->getByHash($transactionDTO->receiverWalletHash);

        $this->walletService->setSender($senderWallet);
        $this->walletService->setReceiver($receiverWallet);

        $usersTransaction = $this->usersTransService->createPendingTransaction(
            $senderWallet->id,
            $receiverWallet->id,
            $transactionDTO->amount,
            $transactionDTO->commissionPayer
        );
        $this->usersTransService->setTransaction($usersTransaction);

        $transferSums = $this->calculationService->getSumsForTransfer($transactionDTO->commissionPayer, $commission, $transactionDTO->amount);

        $this->checkSenderBalanceForWriteOff($transferSums['sender']);

        $this->transferFunds($transferSums, $commission);

    }

    /**
     * @param $senderSum
     */
    private function checkSenderBalanceForWriteOff($senderSum)
    {
        if (!$this->calculationService->ifEnoughFunds($this->walletService->getSender()->current_balance, $senderSum)) {
            $this->usersTransService->setFailed();
            // Log Reason Somewhere
            throw new BadRequestHttpException('Sender don`t have enough funds for transfer');
        }
    }


    /**
     * @throws \Throwable
     */
    private function transferFunds(array $transferSums, $commission)
    {
        DB::beginTransaction();

        try {
            $this->walletService->chargeSumSender($transferSums['sender']);
            $this->walletService->topUpSumReceiver($transferSums['receiver']);
            $this->systemTransService->createTransaction($this->usersTransService->getTransactionId(), $commission);
            $this->usersTransService->setSuccess();
        } catch (\Exception $e) {
            DB::rollBack();
            // Log Reason Somewhere
            throw $e;
        }

        DB::commit();
    }


}
