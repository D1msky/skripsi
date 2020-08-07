<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function index(){
        $status = \App\Status::all();
        return response()->json($status);
    }
}
