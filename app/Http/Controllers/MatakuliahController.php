<?php

namespace App\Http\Controllers;

use App\Kelas;
use Illuminate\Http\Request;
use \App\Matakuliah;
use \App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class MatakuliahController extends Controller
{
    public function index()
    {
        $matkul = Matakuliah::all();
        return response()->json($matkul);
    }

    public function cekId(Request $request)
    {
        $input = $request->all();
        $matkul = Matakuliah::where('ID_MATAKULIAH', $input['ID'])->count();
        if ($matkul == 1) {
            return response()->json(['STATUS' => false]);
        } else {
            return response()->json(['STATUS' => true]);
        }
    }

    public function cekSingkatan(Request $request)
    {
        $input = $request->all();
        $matkul = Matakuliah::where('SINGKATAN_MATKUL', $input['SINGKATAN'])->count();
        if ($matkul == 1) {
            return response()->json(['STATUS' => false]);
        } else {
            return response()->json(['STATUS' => true]);
        }
    }

    public function add(Request $request)
    {
        try {
            $input = $request->all();
            $matkul = new Matakuliah();
            $matkul->ID_MATAKULIAH = $input[0]['ID_MATAKULIAH'];
            $matkul->NAMA_MATAKULIAH = $input[0]['NAMA_MATAKULIAH'];
            $matkul->SINGKATAN_MATKUL = $input[0]['SINGKATAN_MATKUL'];
            $matkul->SKS = $input[0]['SKS'];
            $matkul->save();
            return response()->json(['STATUS' => true]);
        } catch (\Exception $e) {

            return response()->json(['STATUS' => false]);
        }
    }

    public function update(Request $request)
    {
        try {
            $input = $request->all();
            $matkul = Matakuliah::find($input[0]['ID_MATAKULIAH']);
            $matkul->ID_MATAKULIAH = $input[0]['ID_MATAKULIAH'];
            $matkul->NAMA_MATAKULIAH = $input[0]['NAMA_MATAKULIAH'];
            $matkul->SINGKATAN_MATKUL = $input[0]['SINGKATAN_MATKUL'];
            $matkul->SKS = $input[0]['SKS'];
            $matkul->save();
            return response()->json(['STATUS' => true]);
        } catch (\Exception $e) {

            return response()->json(['STATUS' => false]);
        }
    }

    public function delete(Request $request)
    {
        try {
            $input = $request->all();
            $matkul = Matakuliah::find($input[0]['ID_MATAKULIAH']);
            $matkul->delete();
            return response()->json(['STATUS' => true]);
        } catch (\Exception $e) {

            return response()->json(['STATUS' => false]);
        }
    }

    public function dafMatkul()
    {
        $idUser = auth()->user()->ID_USER;
        $status = auth()->user()->ID_STATUS;
        if ($status == "ST-01") {
            $kelas = DB::table('Users')
                ->select('Kelas.ID_KELAS', 'Kelas.ID_MATAKULIAH', 'Kelas.GRUP', 'Matakuliah.ID_MATAKULIAH'
                , 'Matakuliah.SKS', 'Matakuliah.NAMA_MATAKULIAH', 'Matakuliah.SINGKATAN_MATKUL', 
                DB::raw('(SELECT NAMA FROM Users WHERE Users.ID_USER = Kelas.ID_USER) as DOSEN1'), 
                DB::raw('(SELECT NAMA FROM Users WHERE Users.ID_USER = Kelas.ID_USER1) as DOSEN2'), 
                DB::raw('(SELECT NAMA FROM Users WHERE Users.ID_USER = Kelas.ID_USER2) as DOSEN3'))
                ->join('Kelas_Users', 'Kelas_Users.ID_USER', '=', 'Users.ID_USER')
                ->join('Kelas', 'Kelas.ID_KELAS', '=', 'Kelas_Users.ID_KELAS')
                ->join('Matakuliah', 'Matakuliah.ID_MATAKULIAH', '=', 'Kelas.ID_MATAKULIAH')
                ->where('Users.ID_USER', '=', $idUser)->get();
            return view('matakuliah.mahasiswa', ['dafmatkul' => $kelas]);
        } else {
            $dafmatkul = Kelas::where(function ($query) {
                $query->where('ID_USER', '=', auth()->user()->ID_USER)
                    ->orWhere('ID_USER1', '=', auth()->user()->ID_USER)
                    ->orWhere('ID_USER2', '=', auth()->user()->ID_USER);
            })->get();
            return view('matakuliah.dosen', ['dafmatkul' => $dafmatkul]);
        }
    }

    public function filterDosen()
    {
        $dafmatkul = DB::table('Kelas')
        ->select(DB::raw('SUBSTRING(Matakuliah.ID_MATAKULIAH,1,2) as ID'))
        ->join('Matakuliah','Matakuliah.ID_MATAKULIAH','=','Kelas.ID_MATAKULIAH')
            ->where(function ($query) {
                $query->where('ID_USER', '=', auth()->user()->ID_USER)
                    ->orWhere('ID_USER1', '=', auth()->user()->ID_USER)
                    ->orWhere('ID_USER2', '=', auth()->user()->ID_USER);
            })->distinct('ID')->pluck('ID');
        return response()->json($dafmatkul);
    }

    public function filterKaprodi()
    {
        $dafmatkul = DB::table('Kelas')
        ->select(DB::raw('SUBSTRING(Matakuliah.ID_MATAKULIAH,1,2) as ID'))
        ->join('Matakuliah','Matakuliah.ID_MATAKULIAH','=','Kelas.ID_MATAKULIAH')
        ->join('Users','Users.ID_USER','=','Kelas.ID_USER')
        ->where('Users.ID_PRODI','=',auth()->user()->ID_PRODI)
        ->distinct('ID')->pluck('ID');
        return response()->json($dafmatkul);
    }

    public function cplProdi()
    {
        return view('cpl_prodi.index');
    }

    public function getMatkulProdi(Request $request)
    {
        $input = $request->all();
        $matkul = DB::table('Matakuliah')
            ->select('Matakuliah.ID_MATAKULIAH', 'Matakuliah.NAMA_MATAKULIAH', 'Matakuliah.SKS')
            ->join('Kelas', 'Kelas.ID_MATAKULIAH', '=', 'Matakuliah.ID_MATAKULIAH')
            ->join('Users', 'Users.ID_USER', '=', 'Kelas.ID_USER')
            ->where('Users.ID_PRODI', '=', $input['idProdi'])->distinct('Matakuliah.ID_MATAKULIAH')->get();
        return response()->json($matkul);
    }
}
