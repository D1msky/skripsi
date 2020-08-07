<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Prodi;
use Illuminate\Support\Facades\DB;

class ProdiController extends Controller
{
    public function index(){
        $prodi = DB::table('Prodi')
                ->select('Prodi.ID_PRODI','Prodi.NAMA_PRODI','Prodi.SINGKATAN_PRODI','PRODI.EMAIL_PRODI','PRODI.ID_FAKULTAS','FAKULTAS.NAMA_FAKULTAS')
                ->join('Fakultas','Prodi.ID_FAKULTAS','=','Fakultas.ID_FAKULTAS')->get();
        return response()->json($prodi);
    }

    public function getId(){
        $prodi = Prodi::all()->count();
        $id = $prodi + 1;
        if($prodi == 0){
            return response()->json(['ID' => 'PR-0001']);
        }else{
            $id = "PR-".strval(str_pad($id, 4, '0', STR_PAD_LEFT));
            return response()->json(['ID' => $id]);
        }
    }

    public function add(Request $request){
        try {
            $input = $request->all();
            $prodi = new Prodi();
            $prodi->ID_PRODI = $input[0]['ID_PRODI'];
            $prodi->ID_FAKULTAS = $input[0]['ID_FAKULTAS'];
            $prodi->NAMA_PRODI = $input[0]['NAMA_PRODI'];
            $prodi->SINGKATAN_PRODI = $input[0]['SINGKATAN_PRODI'];
            $prodi->EMAIL_PRODI = $input[0]['EMAIL_PRODI'];
            $prodi->save();
            return response()->json(['STATUS' => true]);
          
        } catch (\Exception $e) {
          
            return response()->json(['STATUS' => false]);
        }
    }

    public function update(Request $request){
        try {
            $input = $request->all();
            $prodi = Prodi::find($input[0]['ID_PRODI']);
            $prodi->ID_PRODI = $input[0]['ID_PRODI'];
            $prodi->ID_FAKULTAS = $input[0]['ID_FAKULTAS'];
            $prodi->NAMA_PRODI = $input[0]['NAMA_PRODI'];
            $prodi->SINGKATAN_PRODI = $input[0]['SINGKATAN_PRODI'];
            $prodi->EMAIL_PRODI = $input[0]['EMAIL_PRODI'];
            $prodi->save();
            return response()->json(['STATUS' => true]);
          
        } catch (\Exception $e) {
          
            return response()->json(['STATUS' => false]);
        }
    }

    public function delete(Request $request){
        try {
            $input = $request->all();
            $prodi = Prodi::find($input[0]['ID_PRODI']);
            $prodi->delete();
            return response()->json(['STATUS' => true]);
          
        } catch (\Exception $e) {
          
            return response()->json(['STATUS' => false]);
        }
    }

    public function setProdi(){
        $idProdi = auth()->user()->ID_PRODI;
        $prodi = Prodi::find($idProdi);
        return response()->json($prodi);
    }

    public function updateSetProdi(Request $request){
        try {
            $input = $request->all();
            $prodi = Prodi::find($input[0]['ID_PRODI']);
            $prodi->ID_FAKULTAS = $input[0]['ID_FAKULTAS'];
            $prodi->NAMA_PRODI = $input[0]['NAMA_PRODI'];
            $prodi->SINGKATAN_PRODI = $input[0]['SINGKATAN_PRODI'];
            $prodi->EMAIL_PRODI = $input[0]['EMAIL_PRODI'];
            $prodi->BOBOT_PERSEN = $input[0]['BOBOT_PERSEN'];
            $prodi->BOBOT_WAKTU = $input[0]['BOBOT_WAKTU'];
            $prodi->BOBOT_CPL = $input[0]['BOBOT_CPL'];

            $prodi->PERSEN_TINGGI = $input[0]['PERSEN_TINGGI'];
            $prodi->PERSEN_SDG_A = $input[0]['PERSEN_SDG_A'];
            $prodi->PERSEN_SDG_B = $input[0]['PERSEN_SDG_B'];
            $prodi->PERSEN_RNDH_A = $input[0]['PERSEN_RNDH_A'];
            $prodi->PERSEN_RNDH_B = $input[0]['PERSEN_RNDH_B'];
            $prodi->PERSEN_SRNDH_A = $input[0]['PERSEN_SRNDH_A'];
            $prodi->PERSEN_SRNDH_B = $input[0]['PERSEN_SRNDH_B'];

            $prodi->save();
            return response()->json(['STATUS' => true]);
          
        } catch (\Exception $e) {
          
            return response()->json(['STATUS' => false]);
        }
    }

    public function cekSingkatan(Request $request){
        $input = $request->all();
        $user = Prodi::whereSingkatanProdi($input['SINGKATAN'])->count();
        if($user == 1){
            return response()->json(['STATUS' => false]);
        }else{
            return response()->json(['STATUS' => true]);
        }
    }
}
