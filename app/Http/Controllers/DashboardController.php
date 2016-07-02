<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;

use App\Kegiatan;
use App\Datduk;
use App\SubKomponen;

/**
 * -----------------------------------------------------------------------------
 * Dashboard Controller
 * -----------------------------------------------------------------------------
 */
class DashboardController extends Controller
{

    public function v1()
    {
        $kegiatans     = Kegiatan::all();
        $datduks       = Datduk::all();
        $sub_komponens = SubKomponen::all();

        $dataset   = [
            'kegiatans' => $kegiatans->sortBy(function ($post) {
                return sprintf('%-12s%s', $post->parent, $post->code);
            })->values(),
            'datduks'       => $datduks,
            'sub_komponens' => $sub_komponens
        ];

        return view("dashboard-v1", $dataset);
    }
}
