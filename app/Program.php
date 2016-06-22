<?php

namespace App;

class Program extends Usulan
{
    
    /**
     * Getter for Parent MAK attribute
     * @param  mixed  $value
     * @return string Parent MAK
     */
    public function getParentAttribute($value)   { return '051.01'; }

    public function getParentIdAttribute($value) { return $this->parent; }

    /**
     * Get Parent
     * @return null Program is root parent now
     */
    public function getParent() { return null; }

    /**
     * Get Collection of Program's Childs
     * @return Collection Collection of Program's Childs
     */
    public function childs()
    {
        return $this->hasMany('App\Kegiatan', 'parent', 'code');
    }

    /**
     * Get Program's Child by it's code
     * @param  string $code Kegiatan's Code
     * @return App\Kegiatan
     */
    public function getChild($code)
    {
        return Kegiatan::where([['parent', $this->code], ['code', $code] ])->firstOrFail();
    }

}
