<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \App\Cpl;
use Carbon;

class CplController extends Controller
{
    public function index(){
        $cpl = DB::table('Cpl')
               ->select('ID_CPL','Cpl.KD_CPL','Prodi.ID_PRODI','Prodi.NAMA_PRODI'
               ,'DESKRIPSI_CPL','Cpl.ID_KATEGORI_CPL','NAMA_KATEGORI')
               ->join('Prodi','Cpl.ID_PRODI','=','Prodi.ID_PRODI')
               ->join('Kategori_Cpl','Kategori_Cpl.ID_KATEGORI_CPL','=','Cpl.ID_KATEGORI_CPL')->get();
        return response()->json($cpl);
    }

    public function add(Request $request){
        try {
            $input = $request->all();
            $Cpl = new Cpl();
            $Cpl->ID_CPL = $input[0]['ID_CPL'];
            $Cpl->KD_CPL = $input[0]['KD_CPL'];
            $Cpl->ID_PRODI = $input[0]['ID_PRODI'];
            $Cpl->ID_KATEGORI_CPL = $input[0]['ID_KATEGORI_CPL'];
            $Cpl->DESKRIPSI_CPL = $input[0]['DESKRIPSI_CPL'];
            $Cpl->save();
            return response()->json(['STATUS' => true]);
          
        } catch (\Exception $e) {
          
            return response()->json(['STATUS' => false]);
        }
    }

    public function update(Request $request){
        try {
            $input = $request->all();
            $Cpl = Cpl::find($input[0]['ID_CPL']);
            $Cpl->KD_CPL = $input[0]['KD_CPL'];
            $Cpl->ID_PRODI = $input[0]['ID_PRODI'];
            $Cpl->ID_KATEGORI_CPL = $input[0]['ID_KATEGORI_CPL'];
            $Cpl->DESKRIPSI_CPL = $input[0]['DESKRIPSI_CPL'];
            $Cpl->save();
            return response()->json(['STATUS' => true]);
          
        } catch (\Exception $e) {
          
            return response()->json(['STATUS' => false]);
        }
    }

    public function delete(Request $request){
        try {
            $input = $request->all();
            $Cpl = Cpl::find($input[0]['ID_CPL']);
            $Cpl->delete();
            return response()->json(['STATUS' => true]);
          
        } catch (\Exception $e) {
          
            return response()->json(['STATUS' => false]);
        }
    }

    public function getId()
    {
        $mytime = Carbon\Carbon::now()->format('Ymd');

        $count = Cpl::where('ID_CPL', 'like', '%' . $mytime . '%')->count();


        if ($count == 0) {
            $id = "CPL-" . $mytime . "-0001";
            return response()->json(['ID' => $id]);
        } else {
            $cpl = Cpl::where('ID_CPL', 'like', '%' . $mytime . '%')->orderBy('ID_CPL', 'desc')->first();
            $splitId = explode('-', $cpl->ID_CPL);
            $id = $splitId[2] + 1;
            $id = "CPL-" . $mytime . "-" . strval(str_pad($id, 4, '0', STR_PAD_LEFT));
            return response()->json(['ID' => $id]);
        }
    }

}
