<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Cash extends Model
{
    protected $fillable = [
        'date',
        'cash_type_id',
        'description',
        'amount',
    ];

    protected $appends = ['amount_str'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('date', 'desc')->orderBy('id', 'desc');
        });

        static::created(function ($item) {
            $user = Auth::user();
            Log::create([
                'user_id' => $user ? $user->id : 2,
                'action' => $item->cash_type->type === 'in' ? 'cash_in' : 'cash_out',
                'details' => [
                    'id' => $item->id,
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

    public function cash_type()
    {
        return $this->belongsTo(CashType::class);
    }
}
