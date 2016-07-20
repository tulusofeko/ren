<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB, Log;

class Komponen extends Usulan
{
    public function __construct(array $attributes = [])
    {
        $this->append('eselon_dua');

        parent::__construct($attributes);
    }

    /**
     * Getter for Parent's instance
     * @return App\SubOutput
     */
    public function getParent()
    {
        try {
            $parent = SubOutput::where('id', $this->parent)->firstOrFail();
            return $parent;
        } catch (Exception $e) {
            return null;
        }
    }
    
    /**
     * Get Collection of Komponen's Childs
     * @return Collection of App\SubKomponen
     */
    public function childs()
    {
        return $this->hasMany('App\SubKomponen', 'parent', 'id');
    }

    /**
     * Get Komponen's Child by it's code
     * @param  string $code SubKomponen's Id
     * @return App\SubKomponen
     */
    public function getChild($code)
    {
        return SubKomponen::where([['parent', $this->code], ['code', $code] ])
            ->firstOrFail();
    }

    /**
     * Setter Komponen's Code
     * Untuk memastikan kode yang masuk sejumlah 3 huruf dengan menambahkan pad
     * @return void
     */
    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = str_pad($value, 3, "0", STR_PAD_LEFT);
    }

    /**
     * Get Usulan's Unit Eselon II
     * @return mixed
     */
    public function getEselonDuaAttribute($value)
    {
        $kegiatans = DB::table('komponens')
            ->join('suboutputs', 'komponens.parent', '=', 'suboutputs.id')
            ->join('outputs', 'suboutputs.parent', '=', 'outputs.id')
            ->join('kegiatans', 'outputs.parent', '=', 'kegiatans.code')
            ->join('programs', 'kegiatans.parent', '=', 'programs.code')
            ->select('kegiatans.*')
            ->where([['komponens.id', $this->id]])->first();
        return $kegiatans->eselondua;
    }
}
