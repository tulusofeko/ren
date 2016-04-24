<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

/**
 * -----------------------------------------------------------------------------
 * Dashboard Controller
 * -----------------------------------------------------------------------------
 */
class DashboardController extends Controller 
{

    public function v1()
    {
        return view("dashboard-v1");
    }

}