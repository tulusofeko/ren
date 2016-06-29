<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubKomponen extends Usulan
{
    /**
     * Getter for Parent's instance
     * @return App\Komponen
     */
    public function getParent()
    {
        try {
            $parent = Komponen::find($this->parent)->firstOrFail();
            
            return $parent;
        } catch (Exception $e) { return null; }
    }
    
    /**
     * Get Collection of SubKomponen's Childs
     * @return Collection of App\Aktivitas
     */
    public function childs()
    {
        // return $this->hasMany('App\SubOutput', 'parent', 'id');
    }

    /**
     * Get SubKomponen's Child by it's code
     * @param  string $code Aktivitas's Id
     * @return App\Aktivitas
     */
    public function getChild($code)
    {
        // return Output::where([['kegiatan', $this->code], ['code', $code] ])
            // ->firstOrFail();
    }

    /**
     * Get SubKomponen's Pagu
     * @return mixed
     */
    public function getPaguAttribute($value)
    {
        return number_format($this->anggaran, "0", ",", ".");
    }

    /**
     * Setter SubKomponen's Code
     * Untuk memastikan kode yang masuk Huruf kapital
     * @return void
     */
    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }

    /**
     * Setter SubKomponen's anggaran
     * Untuk memastikan data yang masuk hanya angka
     * @return void
     */
    public function setAnggaranAttribute($value)
    {
        $this->attributes['anggaran'] = str_replace(",", "", $value);
    }
}
