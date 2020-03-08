<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
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

        static::addGlobalScope('order', function(Builder $builder) {
            $builder->orderBy('date', 'desc')->orderBy('id', 'desc');
        });

        static::saved(function() {
            Cache::forget('cash_in_total');
            Cache::forget('cash_out_total');
        });
        static::deleted(function() {
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
