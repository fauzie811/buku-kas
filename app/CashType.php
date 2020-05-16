<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\CashType
 *
 * @property integer $id
 * @property string $type
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read string $type_str
 * @property-read \Illuminate\Database\Eloquent\Collection|Cash $cashes
 */
class CashType extends Model
{
    protected $fillable = ['type', 'description'];

    protected $appends = ['type_str'];

    public function getTypeStrAttribute()
    {
        return $this->type === 'in' ? 'Kas Masuk' : 'Kas Keluar';
    }

    public function cashes()
    {
        return $this->hasMany(Cash::class);
    }
}
