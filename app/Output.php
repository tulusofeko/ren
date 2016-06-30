<?php

namespace App;

use DB;

class Output extends Usulan
{
    /**
     * Getter for Parent's instance
     * @return App\Kegiatan
     */
    public function getParent()
    {
        try {
            $parent = Kegiatan::where('code', $this->parent)->firstOrFail();
            
            return $parent;
        } catch (Exception $e) {
            return null;
        }
    }
    
    /**
     * Get Collection of Kegiatan's Childs
     * @return Collection of App\SubOutput
     */
    public function childs()
    {
        return $this->hasMany('App\SubOutput', 'parent', 'id');
    }

    /**
     * Get Kegiatan's Child by it's code
     * @param  string $code SubOutput's Id
     * @return App\Output
     */
    public function getChild($code)
    {
        return SubOutput::where([['parent', $this->id], ['code', $code] ])->firstOrFail();
    }

    /**
     * Setter Output's Code
     * Untuk memastikan kode yang masuk sejumlah 3 huruf dengan menambahkan pad
     */
    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = str_pad($value, 3, "0", STR_PAD_LEFT);
    }
}
