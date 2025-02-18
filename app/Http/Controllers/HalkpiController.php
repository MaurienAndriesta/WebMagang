<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KPI;

class KPIController extends Controller
{
    public function index()
    {
        $KPIs = KPI::all();
        return view('KPI_evaluation', compact('KPIs'));
    }
}
