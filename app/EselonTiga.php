<?php

namespace App;

use DB;

class EselonTiga extends UnitKerja
{
    protected $table = "eselon_tiga";

    protected $appends  = [
        'durasi',
        'durasi_sum',
        'pagu',
        'perkiraan',
        'sub_komponens',
        'datduks'
    ];

    protected $hari_kerja = 341;

    /**
     * Get Usulan's Durasi
     * @return mixed
     */
    public function getDurasiAttribute($value)
    {
        $durasi = DB::table('aktivitas')
            ->join('sub_komponens', 'aktivitas.parent', '=', 'sub_komponens.id')
            ->select('aktivitas.*')
            ->where([
                ['sub_komponens.unit_kerja', $this->codename]
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
            ->select('aktivitas.*')
            ->where([
                ['sub_komponens.unit_kerja', $this->codename]
            ])->sum('durasi_sum');
        return $durasi;
    }

    /**
     * Get Usulan's Pagu
     * @return mixed
     */
    public function getPaguAttribute($value)
    {
        $subkomponen = DB::table('sub_komponens')
            ->select('sub_komponens.*')
            ->where([
                ['sub_komponens.unit_kerja', $this->codename]
            ])->sum('anggaran');
        return number_format($subkomponen, "0", ",", ".");
    }

    public function getPerkiraanAttribute($value)
    {
        try {
            $perkiraan = $this->durasi_sum / $this->hari_kerja / $this->pegawai;
        } catch (Exception $e) {
            $perkiraan = 0;
        }

        return round($perkiraan/344*100);
    }

    /**
     * Get Usulan's SubKomponen
     * @return mixed
     */
    public function getSubKomponensAttribute($value)
    {
        $subkomponens = DB::table('sub_komponens')
            ->select('sub_komponens.*')
            ->where([
                ['sub_komponens.unit_kerja', $this->codename]
            ])->get();
        return $subkomponens;
    }

    public function getDatduksAttribute($value)
    {
        $datduks = DB::table('datduks')
            ->join('sub_komponens', 'datduks.parent', '=', 'sub_komponens.id')
            ->select('datduks.*')
            ->where([
                ['sub_komponens.unit_kerja', $this->codename]
            ])->get();

        return collect($datduks);
    }
}
