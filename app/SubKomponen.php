<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class SubKomponen extends Usulan
{
    /**
     * Getter for Parent's instance
     * @return App\Komponen
     */
    public function getParent()
    {
        try {
            $parent = Komponen::where('id', $this->parent)->firstOrFail();
            return $parent;
        } catch (Exception $e) {
            return null;
        }
    }
    
    /**
     * Get Collection of SubKomponen's Childs
     * @return Collection of App\Aktivitas
     */
    public function childs()
    {
        return $this->hasMany('App\Aktivitas', 'parent', 'id');
    }

    /**
     * Get SubKomponen's Child by it's code
     * @param  string $code Aktivitas's Id
     * @return App\Aktivitas
     */
    public function getChild($id)
    {
        return Aktivitas::where([['parent', $this->id], ['id', $id] ])->firstOrFail();
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

    public function getUnitAttribute($value)
    {
        return $this->attributes['unit_kerja'];
    }

    public function getDatdukAttribute($value)
    {
        $datduks = DB::table('datduks')
            ->join('sub_komponens', 'datduks.parent', '=', 'sub_komponens.id')
            ->join('komponens', 'sub_komponens.parent', '=', 'komponens.id')
            ->join('suboutputs', 'komponens.parent', '=', 'suboutputs.id')
            ->join('outputs', 'suboutputs.parent', '=', 'outputs.id')
            ->join('kegiatans', 'outputs.parent', '=', 'kegiatans.code')
            ->select('datduks.*')
            ->where([
                ['datduks.parent', $this->id]
            ])->get();

        return collect($datduks)->count();
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
