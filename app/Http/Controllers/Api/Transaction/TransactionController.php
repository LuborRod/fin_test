<?php

namespace App\Http\Controllers\Api\Transaction;

use App\DTO\TransactionDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Services\TransferFundsService;

class TransactionController extends Controller
{
    private TransferFundsService $transferFundsService;

    public function __construct(TransferFundsService $transferFundsService)
    {
        $this->transferFundsService = $transferFundsService;
    }


    public function store(TransactionRequest $transactionRequest)
    {
        $transactionData = new TransactionDTO(
            $transactionRequest->input('sender_wallet'),
            $transactionRequest->input('receiver_wallet'),
            $transactionRequest->input('amount'),
            $transactionRequest->input('commission_payer'),
        );

        $this->transferFundsService->createOperation($transactionData);
    }
}
