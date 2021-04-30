<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\UsersTransService
 *
 * @property int $id
 * @property string $date_created
 * @property int $sender_wallet_id
 * @property int $receiver_wallet_id
 * @property int $amount
 * @property int $commission_payer
 * @property-read \App\Models\Wallet|null $receiverWallet
 * @property-read \App\Models\Wallet|null $senderWallet
 * @property-read \Illuminate\Database\Eloquent\Collection|UsersTransaction[] $systemTransactions
 * @property-read int|null $system_transactions_count
 * @method static \Illuminate\Database\Eloquent\Builder|UsersTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UsersTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UsersTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|UsersTransaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsersTransaction whereCommissionPayer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsersTransaction whereDateCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsersTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsersTransaction whereReceiverWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsersTransaction whereSenderWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsersTransaction whereStatus($value)
 * @mixin \Eloquent
 */
class UsersTransaction extends Model
{
    use HasFactory;

    const MIN_AMOUNT_FOR_TRANSFER = 0.00000001;
    const MAX_AMOUNT_FOR_TRANSFER = 10000;

    const COMMISSION_PAYER_SENDER = 1;
    const COMMISSION_PAYER_RECEIVER = 2;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sender_wallet_id',
        'receiver_wallet_id',
        'amount',
        'date_created',
        'commission_payer',
    ];


    /**
     * @return HasMany
     */
    public function systemTransactions(): HasMany
    {
        return $this->hasMany(UsersTransaction::class);
    }


    /**
     * @return HasOne
     */
    public function senderWallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }


    /**
     * @return HasOne
     */
    public function receiverWallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }


}
