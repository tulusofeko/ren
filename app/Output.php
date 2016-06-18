<?php

namespace App;

class Output extends Usulan
{

    public function getParentAttribute($value)
    {
        $parent = $this->getParent();
        
        return $parent->mak;
    }

    public function getParent()
    {
        try {
            $parent = Kegiatan::where('code', $this->kegiatan)->firstOrFail();
            
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
