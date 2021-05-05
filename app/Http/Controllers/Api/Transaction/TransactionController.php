<?php

namespace App\Http\Controllers\Api\Transaction;

use App\Contracts\DTO\Transaction\ITransactionData;
use App\Contracts\Services\Calculation\ICalculationService;
use App\Contracts\Services\TransferFunds\ITransferFundsService;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use Illuminate\Http\JsonResponse;

class TransactionController extends Controller
{
    private ITransferFundsService $transferFundsService;
    private ICalculationService $calculationService;
    private ITransactionData $transactionData;

    public function __construct(
        ITransferFundsService $transferFundsService,
        ICalculationService $calculationService,
        ITransactionData $transactionData
    )

    {
        $this->transferFundsService = $transferFundsService;
        $this->calculationService = $calculationService;
        $this->transactionData = $transactionData;
    }

    /**
     * @param TransactionRequest $transactionRequest
     * @return JsonResponse
     * @throws \Throwable
     */
    public function store(TransactionRequest $transactionRequest): JsonResponse
    {
        $amount = $this->calculationService->convertBtcToSatoshi($transactionRequest->input('amount'));

        $this->transactionData->create(
            $transactionRequest->input('sender_wallet'),
            $transactionRequest->input('receiver_wallet'),
            $amount,
            $transactionRequest->input('commission_payer')
        );

        $this->transferFundsService->createOperation($this->transactionData);

        return response()->json('OK', 201);
    }
}
