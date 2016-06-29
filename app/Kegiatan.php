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
     * Get Kegiatan's Pagu
     * @return mixed
     */
    public function getPaguAttribute($value)
    {
        $subkomponen = DB::table('sub_komponens')
            ->join('komponens', 'sub_komponens.parent', '=', 'komponens.id')
            ->join('suboutputs', 'komponens.parent', '=', 'suboutputs.id')
            ->join('outputs', 'suboutputs.parent', '=', 'outputs.id')
            ->join('kegiatans', 'outputs.parent', '=', 'kegiatans.code')
            ->select('sub_komponens.*')
            ->where([
                ['kegiatans.code', $this->code] 
            ])->sum('anggaran');
        return number_format($subkomponen, "0", ",", ".");
    }
}
