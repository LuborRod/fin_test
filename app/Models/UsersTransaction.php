<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UsersTransaction extends Model
{
    use HasFactory;

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
