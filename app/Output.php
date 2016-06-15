<?php

namespace App;

class Output extends Usulan
{

    public function getParentAttribute($value)
    {
        $parent = rtrim($this->mak, $this->code);
        $parent = rtrim($parent, ".");
        
        return $parent;
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

    public function getChilds()
    {
        return collect();
        // return Output::where('kegiatan', $this->code)->get();
    }

    public function getChild($code)
    {
        // return Output::where([['kegiatan', $this->code], ['code', $code] ])
            // ->firstOrFail();
    }

    public function setMak()
    {
        $parent = $this->getParent();

        $this->mak = $parent->mak . "." . $this->code;
    }
}
