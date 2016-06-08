<?php

namespace App;

class Kegiatan extends Usulan
{

    public function getStateAttribute($value)
    {
        return 'closed';
    }
    
    public function getParentIdAttribute($value)
    {
        $parent = Program::where('code', $this->program)->firstOrFail();
        
        return $parent->mak;
    }

    public function getMakAttribute($value)
    {
        return $this->parentId . '.' . $this->code;
    }

    public function getChilds()
    {
        // return Kegiatan::where('program', $this->code)->get();
    }

    public function getChild($code)
    {
        // return Kegiatan::where([['program', $this->code], ['code', $code] ])
            // ->firstOrFail();
    }
}
