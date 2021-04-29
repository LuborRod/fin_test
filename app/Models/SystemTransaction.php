<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\SystemTransService
 *
 * @property-read \App\Models\UsersTransaction|null $usersTransaction
 * @method static \Illuminate\Database\Eloquent\Builder|SystemTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemTransaction query()
 * @mixin \Eloquent
 */
class SystemTransaction extends Model
{
    use HasFactory;

    protected $table = 'system_balance';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transaction_id',
        'amount',
        'current_balance',
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function usersTransaction(): HasOne
    {
        return $this->hasOne(UsersTransaction::class);
    }
}
