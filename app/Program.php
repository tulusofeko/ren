<?php

namespace App;

class Program extends Usulan
{

    public function getStateAttribute($value)
    {
        return 'closed';
    }
    
    public function getParentIdAttribute($value)
    {
        return '051.01';
    }

    public function getChilds()
    {
        return Kegiatan::where('program', $this->code)->get();
    }

    public function getChild($code)
    {
        return Kegiatan::where([['program', $this->code], ['code', $code] ])
            ->firstOrFail();
    }
}
