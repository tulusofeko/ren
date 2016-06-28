<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubKomponen extends Usulan
{
    public function getParent()
    {
        try {
            $parent = Komponen::find($this->parent)->firstOrFail();
            
            return $parent;
        } catch (Exception $e) {

            return null;
        }
    }
    
    public function childs()
    {
        // return $this->hasMany('App\SubOutput', 'parent', 'id');
    }

    public function getChild($code)
    {
        // return Output::where([['kegiatan', $this->code], ['code', $code] ])
            // ->firstOrFail();
    }

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }

    public function setAnggaranAttribute($value)
    {
        $this->attributes['anggaran'] = str_replace(",", "", $value);
    }
}
