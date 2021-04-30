<?php

namespace App\Http\Controllers\Api\Transaction;

use App\DTO\TransactionDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Services\TransferFundsService;
use Illuminate\Http\JsonResponse;

class TransactionController extends Controller
{
    private TransferFundsService $transferFundsService;

    public function __construct(TransferFundsService $transferFundsService)
    {
        $this->transferFundsService = $transferFundsService;
    }

    /**
     * @param TransactionRequest $transactionRequest
     * @return JsonResponse
     * @throws \Throwable
     */
    public function store(TransactionRequest $transactionRequest): JsonResponse
    {
        $transactionData = new TransactionDTO(
            $transactionRequest->input('sender_wallet'),
            $transactionRequest->input('receiver_wallet'),
            (int)($transactionRequest->input('amount') * $this->transferFundsService::FORMAT_BTC_TO_SATOSHI),
            $transactionRequest->input('commission_payer'),
        );

        $this->transferFundsService->createOperation($transactionData);

        return response()->json('OK', 201);
    }
}
