<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Kelas;
use App\Kelas_User;
use \App\Tugas;
use Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class TugasController extends Controller
{
    public function index($id)
    {
        try {
            //Proteksi Get Kelas 
            $idUser = auth()->user()->ID_USER;
            $status = auth()->user()->ID_STATUS;

            if ($status == "ST-01") {
                $cek = Kelas_User::where('ID_USER', '=', $idUser)->where('ID_KELAS', '=', $id)->count();
                if ($cek == 0) {
                    return redirect('/');
                } else {
                    $kelas = Kelas::find($id);
                    return view('tugas.mahasiswa', ['matkul' => $kelas->matakuliah, 'idKelas' => $kelas->ID_KELAS]);
                }

            } else {
                $cek = Kelas::where(function ($query) {
                    $query->where('ID_USER', '=', auth()->user()->ID_USER)
                        ->orWhere('ID_USER1', '=', auth()->user()->ID_USER)
                        ->orWhere('ID_USER2', '=', auth()->user()->ID_USER);
                })->where('ID_KELAS', '=', $id)->count();
                if ($cek == 0) {
                    return redirect('/');
                } else {
                    $kelas = Kelas::find($id);
                    return view('tugas.index', ['matkul' => $kelas->matakuliah, 'idKelas' => $kelas->ID_KELAS]);
                }
            }
        } catch (\Exception $e) {

            return redirect('/');
        }
    }

    public function getData(Request $request)
    {
        $input = $request->all();
        $tugas = Tugas::whereIdKelas($input['idKelas'])->get();
        return response()->json($tugas);
    }

    public function getId()
    {
        $mytime = Carbon\Carbon::now()->format('Ymd');
        $tugas = Tugas::all()->count();
        $id = $tugas + 1;
        if ($tugas == 0) {
            $id = "TGS-" . $mytime . "-001";
            return response()->json(['ID' => $id]);
        } else {
            $id = "TGS-" . $mytime . "-" . strval(str_pad($id, 3, '0', STR_PAD_LEFT));
            return response()->json(['ID' => $id]);
        }
    }

    public function add(Request $request)
    {
        try {
            $input = $request->all();
            $tugas = new Tugas();
            $tugas->ID_TUGAS = $input[0]['ID_TUGAS'];
            $tugas->ID_KELAS = $input[0]['ID_KELAS'];
            $tugas->NAMA_TUGAS = $input[0]['NAMA_TUGAS'];
            $tugas->PERSEN = $input[0]['PERSEN'];
            $tugas->WAKTU_MULAI = Carbon\Carbon::now();
            $tugas->WAKTU_SELESAI = $input[0]['WAKTU_SELESAI'];
            $tugas->save();
            return response()->json(['STATUS' => true]);
        } catch (\Exception $e) {

            return response()->json(['STATUS' => false]);
        }
    }

    public function update(Request $request)
    {
        try {
            $input = $request->all();
            $tugas = Tugas::find($input[0]['ID_TUGAS']);
            $tugas->ID_KELAS = $input[0]['ID_KELAS'];
            $tugas->NAMA_TUGAS = $input[0]['NAMA_TUGAS'];
            $tugas->PERSEN = $input[0]['PERSEN'];
            $tugas->WAKTU_MULAI = $input[0]['WAKTU_MULAI'];
            $tugas->WAKTU_SELESAI = $input[0]['WAKTU_SELESAI'];
            $tugas->save();
            return response()->json(['STATUS' => true]);
        } catch (\Exception $e) {

            return response()->json(['STATUS' => false]);
        }
    }


    public function delete(Request $request)
    {
        try {
            $input = $request->all();
            $tugas = Tugas::find($input[0]['ID_TUGAS']);
            $tugas->delete();
            return response()->json(['STATUS' => true]);
        } catch (\Exception $e) {

            return response()->json(['STATUS' => false]);
        }
    }
}
