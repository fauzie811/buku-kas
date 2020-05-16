<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Log
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $action
 * @property array $details
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read string $description
 * @property-read string $details_str
 * @property-read string $color
 * @property-read User $user
 */
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
                if (isset($this->details['cashbook'])) {
                    return "membuat kas masuk di {$this->details['cashbook']}";
                }
                return "membuat kas masuk";
            case 'cash_out':
                if (isset($this->details['cashbook'])) {
                    return "membuat kas keluar di {$this->details['cashbook']}";
                }
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
