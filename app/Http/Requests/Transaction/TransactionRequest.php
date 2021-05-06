<?php

namespace App\Http\Requests\Transaction;

use App\Http\Requests\AbstractRequest;
use App\Models\UsersTransaction;
use App\Repositories\Wallet\WalletRepository;
use App\Rules\CommissionPayerRule;
use App\Rules\WalletHashRule;

class TransactionRequest extends AbstractRequest
{
    /**
     * We skip this check. Look to README.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param WalletRepository $walletRepository
     * @return array
     */
    public function rules(WalletRepository $walletRepository): array
    {
        $minTransactionAmount = UsersTransaction::MIN_AMOUNT_FOR_TRANSFER;
        $maxTransactionAmount = UsersTransaction::MAX_AMOUNT_FOR_TRANSFER;

        return [
            'senderWalletHash' => ['required', new WalletHashRule($walletRepository)],
            'receiverWalletHash' => ['required','different:sender_wallet', new WalletHashRule($walletRepository)],
            'amount' => "required|numeric|between:$minTransactionAmount,$maxTransactionAmount",
            'commissionPayer' => ['integer', new CommissionPayerRule]
        ];
    }
}
