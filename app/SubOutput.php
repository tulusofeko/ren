<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Output;

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
        // return null;
        // return $this->hasMany('App\SubOutput', 'parent', 'id');
    }

    public function getChild($code)
    {
        // return Output::where([['kegiatan', $this->code], ['code', $code] ])
            // ->firstOrFail();
    }
}
