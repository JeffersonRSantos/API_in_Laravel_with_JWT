<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PainelController extends Controller
{
    public function produtos(){
        return view('dashboard.produtos');
        //return view('dashboard.produtos');
    }

    public function access(){
        return view('dashboard.access');
    }
}
