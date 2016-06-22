<?php

namespace App;

class Output extends Usulan
{

    public function getParentIdAttribute($value)
    {
        return $this->getParent()->mak;
    }

    public function getParent()
    {
        try {
            $parent = Kegiatan::where('code', $this->parent)->firstOrFail();
            
            return $parent;
        } catch (Exception $e) {

            return null;
        }
    }
    
    public function childs()
    {
        // return collect();
        // return Output::where('kegiatan', $this->code)->get();
    }

    public function getChild($code)
    {
        // return Output::where([['kegiatan', $this->code], ['code', $code] ])
            // ->firstOrFail();
    }

}
