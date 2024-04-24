<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function __invoke()
    {
        return view('admin.statistic');
    }
}
