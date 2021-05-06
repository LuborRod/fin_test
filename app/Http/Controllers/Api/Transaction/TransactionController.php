<?php

namespace App\Http\Controllers\Api\Transaction;

use App\Contracts\Services\Calculation\ICalculationService;
use App\DTO\Transaction\TransactionData;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Transaction\TransactionRequest;
use App\Services\TransferFunds\TransferFundsService;
use Illuminate\Http\JsonResponse;

class TransactionController extends BaseController
{
    private TransferFundsService $transferFundsService;
    private ICalculationService $calculationService;
    private TransactionData $transactionData;

    public function __construct(
        TransferFundsService $transferFundsService,
        ICalculationService $calculationService,
        TransactionData $transactionData
    )

    {
        $this->transferFundsService = $transferFundsService;
        $this->calculationService = $calculationService;
        $this->transactionData = $transactionData;
    }

    /**
     * @OA\Info(
     *   title="Transfer Funds  API",
     *   version="1.0.0",
     *   @OA\Contact(
     *     email="r.liuborets@andersenlab.com"
     *   )
     * ),
     * @OA\Post(path="/api/transactions",
     *   tags={"Transactions"},
     *   summary="Create transaction",
     *   description="Create transaction for transfer funds",
     *   operationId="createTransaction",
     *   @OA\RequestBody(
     *       required=true,
     *       description="Created transaction",
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(ref="#/components/schemas/TransactionData")
     *       )
     *   ),
     *     @OA\Response(
     *         response=201,
     *         description="Created",
     *         @OA\Schema(
     *             type="json",
     *         ),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found",
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Method Not Allowed",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *     ),
     *
     * )
     * @param TransactionRequest $transactionRequest
     * @return JsonResponse
     * @throws \Throwable
     * )
     */
    public function store(TransactionRequest $transactionRequest): JsonResponse
    {
        $amount = $this->calculationService->convertBtcToSatoshi($transactionRequest->input('amount'));

        $this->transactionData->create(
            $transactionRequest->input('senderWalletHash'),
            $transactionRequest->input('receiverWalletHash'),
            $amount,
            $transactionRequest->input('commissionPayer')
        );

        $this->transferFundsService->createOperation($this->transactionData);

        return $this->success(self::CREATED, JsonResponse::HTTP_CREATED);
    }
}
