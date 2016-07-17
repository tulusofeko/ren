<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

abstract class Usulan extends Model
{
    abstract public function getParent();
    abstract public function getChild($code);
    abstract public function childs();

    protected $appends  = [
        'parentId',
        'mak',
        'level',
        'state',
        'pagu',
        'personil',
        'durasi',
        'durasi_sum'
    ];

    protected $state    = 'closed';

    /**
     * Getter for Parent MAK attribute
     * @param  mixed  $value
     * @return string Parent MAK
     */
    public function getParentIdAttribute($value)
    {
        return $this->getParent()->mak;
    }

    /**
     * Getter for MAK attribute
     * @param  mixed  $value
     * @return string Node MAK
     */
    public function getMakAttribute($value)
    {
        return $this->parent_id . "." . $this->code;
    }

    /**
     * Getter for State attribute, untuk menentukan leaf atau tree
     * @param  mixed  $value
     * @return string state
     */
    public function getStateAttribute($value)
    {
        return $this->state;
    }
    
    /**
     * Getter for level attribute, untuk menentukan aksi dari row klik
     * @param  mixed  $value
     * @return string node level
     */
    public function getlevelAttribute($value)
    {
        $namespace = get_called_class();
        $class     = substr($namespace, strrpos($namespace, '\\')+1);

        return strtolower($class);
    }

    /**
     * Get Usulan's Pagu
     * @return mixed
     */
    public function getPaguAttribute($value)
    {
        $subkomponen = DB::table('sub_komponens')
            ->join('komponens', 'sub_komponens.parent', '=', 'komponens.id')
            ->join('suboutputs', 'komponens.parent', '=', 'suboutputs.id')
            ->join('outputs', 'suboutputs.parent', '=', 'outputs.id')
            ->join('kegiatans', 'outputs.parent', '=', 'kegiatans.code')
            ->join('programs', 'kegiatans.parent', '=', 'programs.code')
            ->select('sub_komponens.*')
            ->where([
                [$this->getTable() . '.id', $this->id]
            ])->sum('anggaran');
        return number_format($subkomponen, "0", ",", ".");
    }

    /**
     * Get Usulan's Personil
     * @return mixed
     */
    public function getPersonilAttribute($value)
    {
        $personil = DB::table('aktivitas')
            ->join('sub_komponens', 'aktivitas.parent', '=', 'sub_komponens.id')
            ->join('komponens', 'sub_komponens.parent', '=', 'komponens.id')
            ->join('suboutputs', 'komponens.parent', '=', 'suboutputs.id')
            ->join('outputs', 'suboutputs.parent', '=', 'outputs.id')
            ->join('kegiatans', 'outputs.parent', '=', 'kegiatans.code')
            ->join('programs', 'kegiatans.parent', '=', 'programs.code')
            ->select('aktivitas.*')
            ->where([
                [   $this->getTable() . '.id', $this->id]
            ])->sum('personil');
        return $personil;
    }

    /**
     * Get Usulan's Durasi
     * @return mixed
     */
    public function getDurasiAttribute($value)
    {
        $durasi = DB::table('aktivitas')
            ->join('sub_komponens', 'aktivitas.parent', '=', 'sub_komponens.id')
            ->join('komponens', 'sub_komponens.parent', '=', 'komponens.id')
            ->join('suboutputs', 'komponens.parent', '=', 'suboutputs.id')
            ->join('outputs', 'suboutputs.parent', '=', 'outputs.id')
            ->join('kegiatans', 'outputs.parent', '=', 'kegiatans.code')
            ->join('programs', 'kegiatans.parent', '=', 'programs.code')
            ->select('aktivitas.*')
            ->where([
                [   $this->getTable() . '.id', $this->id]
            ])->sum('durasi');
        return $durasi;
    }

    /**
     * Get Usulan's Durasi
     * @return mixed
     */
    public function getDurasiSumAttribute($value)
    {
        $durasi = DB::table('aktivitas')
            ->join('sub_komponens', 'aktivitas.parent', '=', 'sub_komponens.id')
            ->join('komponens', 'sub_komponens.parent', '=', 'komponens.id')
            ->join('suboutputs', 'komponens.parent', '=', 'suboutputs.id')
            ->join('outputs', 'suboutputs.parent', '=', 'outputs.id')
            ->join('kegiatans', 'outputs.parent', '=', 'kegiatans.code')
            ->join('programs', 'kegiatans.parent', '=', 'programs.code')
            ->select('aktivitas.*')
            ->where([
                [   $this->getTable() . '.id', $this->id]
            ])->sum('durasi_sum');
        return $durasi;
    }

    /**
     * Set the Programs's name. Name Attribute
     * Untuk memastikan data yang masuk dengan huruf kapital di awal
     * @param  string  $value
     * @return string
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords(strtolower($value));
    }
}
