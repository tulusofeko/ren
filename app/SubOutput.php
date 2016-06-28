<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Output;
use App\Komponen;

class SubOutput extends Usulan
{
    protected $table = 'suboutputs';
    
    public function getParent()
    {
        try {
            $parent = Output::find($this->parent)->firstOrFail();
            
            return $parent;
        } catch (Exception $e) {

            return null;
        }
    }
    
    public function childs()
    {
        return $this->hasMany('App\Komponen', 'parent', 'id');
    }

    public function getChild($code)
    {
        return Komponen::where([['parent', $this->code], ['code', $code] ])
            ->firstOrFail();
    }

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = str_pad($value, 3, "0", STR_PAD_LEFT);
    }
}
