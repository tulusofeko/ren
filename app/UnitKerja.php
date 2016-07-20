<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnitKerja extends Model
{
    protected $guarded = [];
    
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords(strtolower($value));
    }

    public function setCodenameAttribute($value)
    {
        $this->attributes['codename'] = strtoupper($value);
    }
}
