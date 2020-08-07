<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Fakultas;

class FakultasController extends Controller
{
    public function index(){
        $fakultas = Fakultas::all();
        return response()->json($fakultas);
    }

    public function getId(){
        $fakultas = Fakultas::all()->count();
        $id = $fakultas + 1;
        if($fakultas == 0){
            return response()->json(['ID' => 'FK-0001']);
        }else{
            $id = "FK-".strval(str_pad($id, 4, '0', STR_PAD_LEFT));
            return response()->json(['ID' => $id]);
        }
    }

    public function add(Request $request){
        try {
            $input = $request->all();
            $fakultas = new Fakultas();
            $fakultas->ID_FAKULTAS = $input[0]['ID_FAKULTAS'];
            $fakultas->NAMA_FAKULTAS = $input[0]['NAMA_FAKULTAS'];
            $fakultas->EMAIL_FAKULTAS = $input[0]['EMAIL_FAKULTAS'];
            $fakultas->save();
            return response()->json(['STATUS' => true]);
          
        } catch (\Exception $e) {
          
            return response()->json(['STATUS' => false]);
        }
    }

    public function update(Request $request){
        try {
            $input = $request->all();
            $fakultas = Fakultas::find($input[0]['ID_FAKULTAS']);
            $fakultas->NAMA_FAKULTAS = $input[0]['NAMA_FAKULTAS'];
            $fakultas->EMAIL_FAKULTAS = $input[0]['EMAIL_FAKULTAS'];
            $fakultas->save();
            return response()->json(['STATUS' => true]);
          
        } catch (\Exception $e) {
          
            return response()->json(['STATUS' => false]);
        }
    }

    public function delete(Request $request){
        try {
            $input = $request->all();
            $fakultas = Fakultas::find($input[0]['ID_FAKULTAS']);
            $fakultas->delete();
            return response()->json(['STATUS' => true]);
          
        } catch (\Exception $e) {
          
            return response()->json(['STATUS' => false]);
        }
    }
}
