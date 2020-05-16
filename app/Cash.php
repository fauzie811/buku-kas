<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

/**
 * App\Cash
 *
 * @property integer $id
 * @property integer $cashbook_id
 * @property \Carbon\Carbon $date
 * @property integer $cash_type_id
 * @property string $description
 * @property integer $amount
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read string $amount_str
 * @property-read Cashbook $cashbook
 * @property-read CashType $cash_type
 */
class Cash extends Model
{
    protected $fillable = [
        'cashbook_id',
        'date',
        'cash_type_id',
        'description',
        'amount',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    protected $appends = ['amount_str'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('date', 'desc')->orderBy('id', 'desc');
        });

        static::created(function (Cash $item) {
            $user = Auth::user();
            Log::create([
                'user_id' => $user ? $user->id : 2,
                'action' => $item->cash_type->type === 'in' ? 'cash_in' : 'cash_out',
                'details' => [
                    'id' => $item->id,
                    'cashbook' => $item->cashbook->name,
                    'date' => $item->date->format('Y-m-d'),
                    'description' => $item->description,
                    'amount' => $item->amount,
                ],
            ]);
        });
        static::saved(function () {
            Cache::forget('cash_in_total');
            Cache::forget('cash_out_total');
        });
        static::deleted(function () {
            Cache::forget('cash_in_total');
            Cache::forget('cash_out_total');
        });
    }

    public function getAmountStrAttribute()
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    public function cashbook()
    {
        return $this->belongsTo(Cashbook::class);
    }

    public function cash_type()
    {
        return $this->belongsTo(CashType::class);
    }
}
