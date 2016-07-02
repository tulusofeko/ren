<?php

namespace App;

use DB;

class Kegiatan extends Usulan
{
    
    /**
     * Getter for Parent MAK attribute
     * @param  mixed  $value
     * @return string Parent MAK
     */
    public function getParentIdAttribute($value)
    {
        return "051.01." . $this->parent;
    }

    /**
     * Getter for Parent's instance
     * @param  mixed  $value
     * @return App\Program
     */
    public function getParent()
    {
        try {
            $parent = Program::where('code', $this->parent)->firstOrFail();
        
            return $parent;

        } catch (Exception $e) {

            return null;
        }
    }

    /**
     * Getter for Unit Kerja's instance
     * @param  mixed  $value
     * @return App\EselonDua
     */
    public function getUnitKerja()
    {
        try {
            $parent = EselonDua::where('codename', $this->eselondua)->firstOrFail();
        
            return $parent;

        } catch (Exception $e) {

            return null;
        }
    }

    /**
     * Get Collection of Kegiatan's Childs
     * @return Collection of App\Output
     */
    public function childs()
    {
        return $this->hasMany('App\Output', 'parent', 'code');
    }
    
    /**
     * Get Kegiatan's Child by it's code
     * @param  string $code Output's Code
     * @return App\Output
     */
    public function getChild($code)
    {
        return Output::where([['parent', $this->code], ['code', $code] ])->firstOrFail();
    }

    /**
     * Get Usulan's SubKomponen
     * @return mixed
     */
    public function getTotalSkAttribute($value)
    {
        $total = DB::table('sub_komponens')
            ->join('komponens', 'sub_komponens.parent', '=', 'komponens.id')
            ->join('suboutputs', 'komponens.parent', '=', 'suboutputs.id')
            ->join('outputs', 'suboutputs.parent', '=', 'outputs.id')
            ->join('kegiatans', 'outputs.parent', '=', 'kegiatans.code')
            ->join('programs', 'kegiatans.parent', '=', 'programs.code')
            ->select('sub_komponens.*')
            ->where([
                [   'kegiatans.id', $this->id]
            ])->count();
        return $total;
    }

    public function getDatduksAttribute($value)
    {
        $total = DB::select(
            "SELECT datduks.* FROM `datduks`
                JOIN sub_komponens ON datduks.parent = sub_komponens.id
                JOIN komponens ON sub_komponens.parent = komponens.id
                JOIN suboutputs ON komponens.parent = suboutputs.id
                JOIN outputs ON suboutputs.parent = outputs.id
                JOIN kegiatans ON outputs.parent = kegiatans.code
            WHERE kegiatans.code = $this->code"
        );

        return collect($total);
    }
}
