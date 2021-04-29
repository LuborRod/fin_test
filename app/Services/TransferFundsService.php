<?php


namespace App\Services;


use App\DTO\TransactionDTO;
use App\Repositories\Interfaces\WalletRepositoryInterface;
use App\Repositories\Interfaces\SystemTransactionsRepositoryInterface;
use App\Repositories\Interfaces\UsersTransactionsRepositoryInterface;

class TransferFundsService
{
    private CalculationService $calculationService;
    private SystemTransactionsRepositoryInterface $systemTransactionsRepository;
    private UsersTransactionsRepositoryInterface $usersTransactionsRepository;
    private WalletRepositoryInterface $walletRepository;

    public function __construct(
        UsersTransactionsRepositoryInterface $usersTransactionsRepository,
        SystemTransactionsRepositoryInterface $systemTransactionsRepository,
        CalculationService $calculationService,
        WalletRepositoryInterface $walletRepository
    )
    {
        $this->usersTransactionsRepository = $usersTransactionsRepository;
        $this->systemTransactionsRepository = $systemTransactionsRepository;
        $this->calculationService = $calculationService;
        $this->walletRepository = $walletRepository;
    }

    public function createOperation(TransactionDTO $transactionDTO)
    {
        $commission = $this->calculationService->getCommissionFromAmount($transactionDTO->amount);

        $senderWallet = $this->walletRepository->getByHash($transactionDTO->senderWalletHash);
        $receiverWallet = $this->walletRepository->getByHash($transactionDTO->receiverWalletHash);

        $usersTransaction = $this->usersTransactionsRepository->createPendingTransaction(
            $senderWallet->id,
            $receiverWallet->id,
            $transactionDTO->amount,
            $transactionDTO->commissionPayer
        );
        $this->usersTransactionsRepository->setTransaction($usersTransaction);


        $this->walletRepository->setSender($senderWallet);
        $this->walletRepository->setReceiver($receiverWallet);

        $sumsForWriteOff = $this->calculationService->getSumsForWriteOff($transactionDTO->commissionPayer, $commission, $transactionDTO->amount);



        $this->checkBalancesForWriteOff($sumsForWriteOff);


    }

    /**
     * @param array $sums
     * @throws \Exception
     */
    private function checkBalancesForWriteOff(array $sums)
    {
        $senderWallet = $this->walletRepository->getSender();
        $receiverWallet = $this->walletRepository->getReceiver();

        if (!$this->calculationService->ifEnoughFunds($senderWallet->current_balance, $sums['sender'])) {
            throw new \Exception('Sender dont have enough funds for transfer');
        }
        if (!$this->calculationService->ifEnoughFunds($receiverWallet->current_balance, $sums['receiver'])) {
            throw new \Exception('Receiver dont have enough funds for transfer');
        }

    }





}
