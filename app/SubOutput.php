<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class SubOutput extends Usulan
{
    protected $table = 'suboutputs';
    
    /**
     * Getter for Parent's instance
     * @return App\Output
     */
    public function getParent()
    {
        try {
            $parent = Output::find($this->parent)->firstOrFail();
            
            return $parent;
        } catch (Exception $e) { return null; }
    }
    
    /**
     * Get Collection of SubOutput's Childs
     * @return Collection of App\Komponen
     */
    public function childs()
    {
        return $this->hasMany('App\Komponen', 'parent', 'id');
    }

    /**
     * Get SubOutput's Child by it's code
     * @param  string $code Komponen's Id
     * @return App\Komponen
     */
    public function getChild($code)
    {
        return Komponen::where([['parent', $this->code], ['code', $code] ])->firstOrFail();
    }

    /**
     * Get SubOutput's Pagu
     * @return mixed
     */
    public function getPaguAttribute($value)
    {
        $subkomponen = DB::table('sub_komponens')
            ->join('komponens', 'sub_komponens.parent', '=', 'komponens.id')
            ->join('suboutputs', 'komponens.parent', '=', 'suboutputs.id')
            ->select('sub_komponens.*')
            ->where([
                ['suboutputs.id', $this->id] 
            ])->sum('anggaran');
        return number_format($subkomponen, "0", ",", ".");
    }

    /**
     * Setter Output's Code
     * Untuk memastikan kode yang masuk sejumlah 3 huruf dengan menambahkan pad
     * @return void
     */
    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = str_pad($value, 3, "0", STR_PAD_LEFT);
    }
}
