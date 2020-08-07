<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Status;
use App\User;

use Illuminate\Support\Facades\DB;
use App\Services\PayUService\Exception;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{
    public function index(){
        //$user = \App\User::with(['status','prodi'])->get();
        $user = DB::table('Users')
                ->select('Users.ID_USER','Users.NAMA','Users.PASSWORD','Users.JENIS_KELAMIN','Status.ID_STATUS','Status.NAMA_STATUS','Prodi.ID_PRODI','Prodi.NAMA_PRODI')
                ->join('Status','Users.ID_STATUS','=','Status.ID_STATUS')
                ->join('Prodi','Users.ID_PRODI','=','Prodi.ID_PRODI')->get();
        return response()->json($user);
    }
    
    public function add(Request $request){
        try {
            $input = $request->all();
            $user = new \App\User();
            $user->id_user = $input[0]['ID_USER'];
            $user->nama = $input[0]['NAMA'];
            $user->password = bcrypt($input[0]['PASSWORD']);
            $user->jenis_kelamin = $input[0]['JENIS_KELAMIN'];
            $user->id_status = $input[0]['ID_STATUS'];
            $user->id_prodi = $input[0]['ID_PRODI'];
            $user->save();
            return response()->json(['STATUS' => true]);
          
        } catch (\Exception $e) {
          
            return response()->json(['STATUS' => false]);
        } 
    }

    public function delete(Request $request){
        try{
            $input = $request->all();
            $user = \App\User::find($input[0]['ID_USER']);
            $user->delete();
            return response()->json(['STATUS' => true]);
        }catch(\Exception $e){
            return response()->json(['STATUS' => false]);
        }
        
    }

    public function update(Request $request){
        try {
            $input = $request->all();
            $user = \App\User::find($input[0]['ID_USER']);
            $user->nama = $input[0]['NAMA'];
            if($user->PASSWORD != $input[0]['PASSWORD']){
                $user->PASSWORD = bcrypt($input[0]['PASSWORD']);
            }
            $user->jenis_kelamin = $input[0]['JENIS_KELAMIN'];
            $user->id_status = $input[0]['ID_STATUS'];
            $user->id_prodi = $input[0]['ID_PRODI'];
            $user->save();
            return response()->json(['STATUS' => true]);
          
        } catch (\Exception $e) {
          
            return response()->json(['STATUS' => false]);
        }
    }

    public function cekId(Request $request){
        try{
            $input = $request->all();
            $user = \App\User::whereIdUser($input['ID'])->count();
            if($user == 1){
                return response()->json(['STATUS' => false]);
            }else{
                return response()->json(['STATUS' => true]);
            }
        } catch (\Exception $e) {
            return response()->json(['STATUS' => false]);
        }
     
    }

    public function getMhs(Request $request){
        $input = $request->all();
        $mhs = DB::table('Users')
                ->select('ID_USER','NAMA')
                ->where('ID_STATUS','=','ST-01')
                ->whereNotIn('ID_USER', 
                DB::table('Kelas_Users')
                ->select('ID_USER')->where('ID_KELAS','=',$input['idKelas']))->get();
        return response()->json($mhs);
    }

    public function getDosen(){
        $user = \App\User::whereIn('ID_STATUS',['ST-02','ST-03'])->get();
        return response()->json($user);
    }
}
