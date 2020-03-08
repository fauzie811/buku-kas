<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = ['user_id', 'action', 'details'];

    protected $casts = [
        'details' => 'array',
    ];

    protected $appends = ['description', 'details_str', 'color'];

    protected static function boot()
    {
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('created_at', 'desc')->orderBy('id', 'desc');
        });
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDescriptionAttribute()
    {
        switch ($this->action) {
            case 'login':
                return 'melakukan login';
            case 'cash_in':
                return 'membuat kas masuk';
            case 'cash_out':
                return 'membuat kas keluar';
            default:
                return '';
        }
    }

    public function getDetailsStrAttribute()
    {
        switch ($this->action) {
            case 'cash_in':
            case 'cash_out':
                return $this->details['date'] . ': ' . $this->details['description'] . ' (' .
                    number_format($this->details['amount'], 0, ',', '.') . ')';
            default:
                return null;
        }
    }

    public function getColorAttribute()
    {
        switch ($this->action) {
            case 'cash_in':
                return 'green';
            case 'cash_out':
                return 'red';
            default:
                return '';
        }
    }
}
