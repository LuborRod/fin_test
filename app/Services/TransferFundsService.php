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

    // Here in real life we can use interfaces.
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

        $writeOffSums = $this->calculationService->getSumsForWriteOff($transactionDTO->commissionPayer, $commission, $transactionDTO->amount);

        $this->checkBalancesForWriteOff($writeOffSums);

        $this->beginTransfer($writeOffSums, $commission);

    }

    /**
     * @param array $sums
     * @throws \Exception
     */
    private function checkBalancesForWriteOff(array $sums)
    {
        if (!$this->calculationService->ifEnoughFunds($this->walletService->getSender()->current_balance, $sums['sender'])) {
            $this->usersTransService->setFailed();
            // Log Reason Somewhere
            throw new BadRequestHttpException('Sender don`t have enough funds for transfer');
        }
        if (!$this->calculationService->ifEnoughFunds($this->walletService->getReceiver()->current_balance, $sums['receiver'])) {
            $this->usersTransService->setFailed();
            // Log Reason Somewhere
            throw new BadRequestHttpException('Receiver don`t have enough funds for transfer');
        }

    }


    /**
     * @throws \Throwable
     */
    private function beginTransfer(array $writeOffSums, $commission)
    {
        DB::beginTransaction();

        try {
            $this->walletService->chargeSumSender($writeOffSums['sender']);
            $this->walletService->chargeSumReceiver($writeOffSums['receiver']);
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
