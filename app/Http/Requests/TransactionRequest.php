<?php

namespace App\Http\Requests;

use App\Models\UsersTransaction;
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
     * @return array
     */
    public function rules(): array
    {
        $minTransactionAmount = UsersTransaction::MIN_AMOUNT_FOR_TRANSFER;

        return [
            'sender_wallet' => ['required', new WalletHashRule],
            'receiver_wallet' => ['required','different:sender_wallet', new WalletHashRule],
            'amount' => "required|integer|gte:$minTransactionAmount",
            'commission_payer' => ['string', new CommissionPayerRule]
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
