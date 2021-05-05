<?php

namespace App\Services\SystemTransactions;

use App\Contracts\Repositories\SystemTransactions\ISystemTransactionsRepository;
use App\Services\BaseService;

class SystemTransService extends BaseService
{
    private ISystemTransactionsRepository $systemTransactionsRepository;

    public function __construct(ISystemTransactionsRepository $systemTransactionsRepository)
    {
        $this->systemTransactionsRepository = $systemTransactionsRepository;
    }


    /**
     * @throws \Throwable
     */
    public function createTransaction(int $userTransactionId, int $commission): void
    {
        $currentBalance = $this->systemTransactionsRepository->getCurrentBalance();

        $this->systemTransactionsRepository->create($userTransactionId, $commission, $currentBalance);
    }
}
