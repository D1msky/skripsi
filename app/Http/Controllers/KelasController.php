<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon;
use \App\Kelas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = DB::table('Kelas')
            ->select('ID_KELAS', 'ID_USER', 'ID_USER1', 'ID_USER2', 'ID_MATAKULIAH', 'GRUP', 'SEMESTER', 'THN_AJARAN', 
            DB::raw('(SELECT NAMA FROM Users WHERE Users.ID_USER = Kelas.ID_USER) as DOSEN1'), 
            DB::raw('(SELECT NAMA FROM Users WHERE Users.ID_USER = Kelas.ID_USER1) as DOSEN2'), 
            DB::raw('(SELECT NAMA FROM Users WHERE Users.ID_USER = Kelas.ID_USER2) as DOSEN3'))
            ->get();
        return response()->json($kelas);
    }

    public function getId()
    {
        $mytime = Carbon\Carbon::now()->format('Ymd');
        $count = Kelas::where('ID_KELAS', 'like', '%' . $mytime . '%')->count();
        if ($count == 0) {
            $id = "KLS-" . $mytime . "-001";
            return response()->json(['ID' => $id]);
        } else {
            $kelas = Kelas::where('ID_KELAS', 'like', '%' . $mytime . '%')->orderBy('ID_KELAS', 'desc')->first();
            $splitId = explode('-', $kelas->ID_KELAS);
            $id = $splitId[2] + 1;
            $id = "KLS-" . $mytime . "-" . strval(str_pad($id, 3, '0', STR_PAD_LEFT));
            return response()->json(['ID' => $id]);
        }
    }

    public function getThnAjaran()
    {
        $mytime = Carbon\Carbon::now()->format('Y') + 2;
        $arr = [];
        for ($i = 1; $i <= 5; $i++) {
            $arr[$i] = $mytime - 1 . "/" . $mytime;
            $mytime -= 1;
        }
        return response()->json($arr);
    }

    public function add(Request $request)
    {
        try {
            $input = $request->all();
            $kelas = new Kelas();
            $kelas->ID_KELAS = $input[0]['ID_KELAS'];
            $kelas->ID_MATAKULIAH = $input[0]['ID_MATAKULIAH'];
            $kelas->ID_USER = $input[0]['ID_DOSEN'];
            $kelas->ID_USER1 = $input[0]['ID_DOSEN2'];
            $kelas->ID_USER2 = $input[0]['ID_DOSEN3'];
            $kelas->GRUP = $input[0]['GROUP'];
            $kelas->SEMESTER = $input[0]['SEMESTER'];
            $kelas->THN_AJARAN = $input[0]['THN_AJARAN'];
            $kelas->save();
            return response()->json(['STATUS' => true]);
        } catch (\Exception $e) {

            return response()->json(['STATUS' => false]);
        }
    }

    public function update(Request $request)
    {
        try {
            $input = $request->all();
            $kelas = Kelas::find($input[0]['ID_KELAS']);
            $kelas->ID_MATAKULIAH = $input[0]['ID_MATAKULIAH'];
            $kelas->ID_USER = $input[0]['ID_DOSEN'];
            $kelas->ID_USER1 = $input[0]['ID_DOSEN2'];
            $kelas->ID_USER2 = $input[0]['ID_DOSEN3'];
            $kelas->GRUP = $input[0]['GROUP'];
            $kelas->SEMESTER = $input[0]['SEMESTER'];
            $kelas->THN_AJARAN = $input[0]['THN_AJARAN'];
            $kelas->save();
            return response()->json(['STATUS' => true]);
        } catch (\Exception $e) {

            return response()->json(['STATUS' => false]);
        }
    }

    public function delete(Request $request)
    {
        try {
            $input = $request->all();
            $kelas = Kelas::find($input[0]['ID_KELAS']);
            $kelas->delete();
            return response()->json(['STATUS' => true]);
        } catch (\Exception $e) {

            return response()->json(['STATUS' => false]);
        }
    }

    public function cekKelas(Request $request)
    {
        try {
            $input = $request->all();
            $kelas = Kelas::where('ID_MATAKULIAH', '=', $input['ID_MATKUL'])->where('GRUP', '=', $input['GRUP'])->count();
            if ($kelas > 0) {
                return response()->json(['STATUS' => false]);
            } else {
                return response()->json(['STATUS' => true]);
            }
        } catch (\Exception $e) {

            return response()->json(['STATUS' => false]);
        }
    }
}
