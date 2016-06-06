<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model implements Uraian
{
    protected $appends = array('state', 'parentId', 'mak');

    /**
     * Set the Programs's name.
     *
     * @param  string  $value
     * @return string
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords(strtolower($value));
    }

    public function getStateAttribute($value)
    {
        return 'closed';
    }
    
    public function getParentIdAttribute($value)
    {
        return '051.01';
    }

    public function getMakAttribute($value)
    {
        return '051.01.'. $this->code;
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
