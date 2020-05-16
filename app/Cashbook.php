<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Cashbook
 *
 * @property integer $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Cash $cashes
 */
class Cashbook extends Model
{
    protected $fillable = ['name'];

    public function cashes()
    {
        return $this->hasMany(Cash::class);
    }
}
