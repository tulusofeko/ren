<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Komponen extends Usulan
{
    public function getParent()
    {
        try {
            $parent = SubOutput::find($this->parent)->firstOrFail();
            
            return $parent;
        } catch (Exception $e) {

            return null;
        }
    }
    
    public function childs()
    {
        return $this->hasMany('App\SubKomponen', 'parent', 'id');
    }

    public function getChild($code)
    {
        return SubKomponen::where([['parent', $this->code], ['code', $code] ])
            ->firstOrFail();
    }

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = str_pad($value, 3, "0", STR_PAD_LEFT);
    }
}
