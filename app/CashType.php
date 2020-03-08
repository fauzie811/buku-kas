<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
