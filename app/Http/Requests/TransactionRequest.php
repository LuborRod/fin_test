<?php

namespace App\Http\Requests;

use App\Models\UsersTransaction;
use App\Repositories\Wallet\WalletRepository;
use App\Rules\CommissionPayerRule;
use App\Rules\WalletHashRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TransactionRequest extends FormRequest
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
            'sender_wallet' => ['required', new WalletHashRule($walletRepository)],
            'receiver_wallet' => ['required','different:sender_wallet', new WalletHashRule($walletRepository)],
            'amount' => "required|numeric|between:$minTransactionAmount,$maxTransactionAmount",
            'commission_payer' => ['integer', new CommissionPayerRule]
        ];
    }

    /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
}
