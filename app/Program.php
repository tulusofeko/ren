<?php

namespace App;

use DB;

class Program extends Usulan
{
    /**
     * Getter for Parent MAK attribute
     * @param  mixed  $value
     * @return string Parent MAK
     */
    public function getParentAttribute($value)   { return '051.01'; }

    /**
     * Getter for Parent MAK attribute
     * @param  mixed  $value
     * @return string Parent MAK
     */
    public function getParentIdAttribute($value) { return $this->parent; }

    /**
     * Get Parent Instance
     * @return null Program is root parent now
     */
    public function getParent() { return null; }

    /**
     * Get Collection of Program's Childs
     * @return Collection of App\Kegiatan
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

    /**
     * Get Program's Personil
     * @return mixed
     */
    public function getPersonilAttribute($value)
    {
        return '-';
    }
}
