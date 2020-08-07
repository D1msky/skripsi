<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Kategori_Cpl;

class Kategori_CplController extends Controller
{
    public function index(){
        $kat_cpl = Kategori_Cpl::all();
        return response()->json($kat_cpl);
    }
}
