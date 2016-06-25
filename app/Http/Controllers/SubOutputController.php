<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\SubOutput as Output;

class SubOutputController extends OutputController
{
    protected $model = 'App\SubOutput';
}
