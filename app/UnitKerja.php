<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnitKerja extends Model
{
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords(strtolower($value));
    }
}
