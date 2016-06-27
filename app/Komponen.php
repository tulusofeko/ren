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
        // return null;
        // return $this->hasMany('App\SubOutput', 'parent', 'id');
    }

    public function getChild($code)
    {
        // return Output::where([['kegiatan', $this->code], ['code', $code] ])
            // ->firstOrFail();
    }
}
