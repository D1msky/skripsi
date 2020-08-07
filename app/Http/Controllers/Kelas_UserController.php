<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Kelas_User;
use \App\Kelas;
use Carbon;
use Illuminate\Support\Facades\DB;

class Kelas_UserController extends Controller
{
    public function index($id){
        $cek = Kelas::find($id);
        if($cek != null){
            return view('kelas_user.index',['idKelas' => $id]);
        }
        else{
            return redirect('/');
        } 
    }

    public function getData(Request $request){
        $input = $request->all();
        $klsuser = DB::table('Kelas_Users')
                   ->select('ID_KELAS_USER','ID_KELAS','Users.ID_USER','NAMA')
                   ->join('Users','Kelas_Users.ID_USER','=','Users.ID_USER')
                   ->where('Kelas_Users.ID_KELAS','=',$input['idKelas'])->get();
        return response()->json($klsuser);
    }

    public function getId(){
        $mytime = Carbon\Carbon::now()->format('Ymd');
        $count = Kelas_User::where('ID_KELAS_USER','like','%'.$mytime.'%')->count();
        
        if($count == 0){
            $id = "KLU-".$mytime."-00001";
            return response()->json(['ID' => $id]);
        }else{
            $klsuser = Kelas_User::where('ID_KELAS_USER','like','%'.$mytime.'%')->orderBy('ID_KELAS_USER','desc')->first();
            $splitId = explode('-',$klsuser->ID_KELAS_USER);
            $id = $splitId[2] + 1;
            $id = "KLU-".$mytime."-".strval(str_pad($id, 5, '0', STR_PAD_LEFT));
            return response()->json(['ID' => $id]);
        }
    }

    public function add(Request $request){
        try {
            $input = $request->all();
            $klsuser = new \App\Kelas_User();
            $klsuser->ID_KELAS_USER = $input[0]['ID_KELAS_USER'];
            $klsuser->ID_KELAS = $input[0]['ID_KELAS'];
            $klsuser->ID_USER = $input[0]['ID_USER'];
            $klsuser->save();
            return response()->json(['STATUS' => true]);
          
        } catch (\Exception $e) {
          
            return response()->json(['STATUS' => false]);
        } 
    }

    public function update(Request $request){
        try {
            $input = $request->all();
            $klsuser = Kelas_User::find($input[0]['ID_KELAS_USER']);
            $klsuser->ID_KELAS = $input[0]['ID_KELAS'];
            $klsuser->ID_USER = $input[0]['ID_USER'];
            $klsuser->save();
            return response()->json(['STATUS' => true]);
          
        } catch (\Exception $e) {
          
            return response()->json(['STATUS' => false]);
        } 
    }

    public function delete(Request $request){
        try {
            $input = $request->all();
            $klsuser = Kelas_User::find($input[0]['ID_KELAS_USER']);
            $klsuser->delete();
            return response()->json(['STATUS' => true]);
          
        } catch (\Exception $e) {
          
            return response()->json(['STATUS' => false]);
        } 
    }
}
