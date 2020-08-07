<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Matakuliah;
use \App\Cpl_Matakuliah;
use App\Kelas;
use Carbon;
use Illuminate\Support\Facades\DB;

class Cpl_MatakuliahController extends Controller
{
    public function index($id)
    {
        $matkul = Matakuliah::find($id);
        if ($matkul == null) {
            return redirect('/');
        }

       
        $cek = DB::table('Kelas')
            ->where(function ($query) {
                $query->where('ID_USER', '=', auth()->user()->ID_USER)
                    ->orWhere('ID_USER1', '=', auth()->user()->ID_USER)
                    ->orWhere('ID_USER2', '=', auth()->user()->ID_USER);
            })
            ->where('ID_MATAKULIAH', '=', $id)->count();

        if ($cek == 0) {
            return redirect('/');
        }
        return view('cpl_matkul.index', ['matkul' => $matkul]);
    }

    public function getData(Request $request)
    {
        $input = $request->all();
        $cplmatkul = DB::table('Cpl_Matakuliah')
            ->select('Cpl.ID_CPL', 'ID_CPL_MATKUL','Cpl.KD_CPL', 'ID_MATAKULIAH', 'DESKRIPSI_CPL', 'BOBOT', 'Cpl_Matakuliah.UPDATED_AT')
            ->join('Cpl', 'Cpl.ID_CPL', '=', 'Cpl_Matakuliah.ID_CPL')
            ->where('ID_MATAKULIAH', '=', $input['idMatkul'])->get();
        return response()->json($cplmatkul);
    }

    public function update(Request $request)
    {
        try {
            $input = $request->all();
            $cplmatkul = Cpl_Matakuliah::find($input[0]['ID_CPL_MATKUL']);
            $cplmatkul->BOBOT = $input[0]['BOBOT'];
            $cplmatkul->save();
            return response()->json(['STATUS' => true]);
        } catch (\Exception $e) {

            return response()->json(['STATUS' => false]);
        }
    }

    public function add(Request $request)
    {
        try {
            $input = $request->all();

            $cplmatkul = new Cpl_Matakuliah();
            $cplmatkul->ID_CPL_MATKUL = $input[0]['ID_CPL_MATKUL'];
            $cplmatkul->ID_CPL = $input[0]['ID_CPL'];
            $cplmatkul->ID_MATAKULIAH = $input[0]['ID_MATAKULIAH'];
            $cplmatkul->BOBOT = $input[0]['BOBOT'];
            $cplmatkul->save();
            return response()->json(['STATUS' => true]);
        } catch (\Exception $e) {

            return response()->json(['STATUS' => false]);
        }
    }

    public function delete(Request $request)
    {
        try {
            $input = $request->all();
            $cplmatkul = Cpl_Matakuliah::find($input[0]['ID_CPL_MATKUL']);
            $cplmatkul->delete();
            return response()->json(['STATUS' => true]);
        } catch (\Exception $e) {

            return response()->json(['STATUS' => false]);
        }
    }

    public function cpl($id)
    {
        try {

            $matkul = Matakuliah::find($id);
            if ($matkul == null) {
                return redirect('/');
            }

            $idUser = auth()->user()->ID_USER;
            $cek = DB::table('Kelas')
                ->where('ID_USER', '=', $idUser)
                ->where('ID_MATAKULIAH', '=', $id)->count();

            if ($cek == 0) {
                return redirect('/');
            }

            return view('cpl_matkul.add', ['matkul' => $matkul]);
        } catch (\Exception $e) {

            return redirect('/');
        }
    }

    public function getId()
    {
        $mytime = Carbon\Carbon::now()->format('Ymd');

        $count = Cpl_Matakuliah::where('ID_CPL_MATKUL', 'like', '%' . $mytime . '%')->count();


        if ($count == 0) {
            $id = "CPM-" . $mytime . "-0001";
            return response()->json(['ID' => $id]);
        } else {
            $cplmatkul = Cpl_Matakuliah::where('ID_CPL_MATKUL', 'like', '%' . $mytime . '%')->orderBy('ID_CPL_MATKUL', 'desc')->first();
            $splitId = explode('-', $cplmatkul->ID_CPL_MATKUL);
            $id = $splitId[2] + 1;
            $id = "CPM-" . $mytime . "-" . strval(str_pad($id, 4, '0', STR_PAD_LEFT));
            return response()->json(['ID' => $id]);
        }
    }

    public function getAddData(Request $request)
    {
        $idProdi = auth()->user()->ID_PRODI;
        $input = $request->all();
        $cpl = DB::table('Cpl')
            ->select('ID_CPL','KD_CPL', 'DESKRIPSI_CPL', 'Cpl.ID_KATEGORI_CPL', 'NAMA_KATEGORI')
            ->join('Kategori_Cpl', 'Kategori_Cpl.ID_KATEGORI_CPL', '=', 'Cpl.ID_KATEGORI_CPL')
            ->where('Cpl.ID_PRODI','=',$idProdi)
            ->whereNotIn('ID_CPL',DB::table('Cpl_Matakuliah')
            ->select('ID_CPL')->where('ID_MATAKULIAH', '=', $input['idMatkul']))->get();
        return response()->json($cpl);
    }

    public function showCplProdi($id)
    {
        $matkul = Matakuliah::find($id);
        if ($matkul == null) {
            return redirect('/');
        }
        return view('cpl_prodi.cpl', ['matkul' => $matkul]);
    }

    public function cplMatkulProdi()
    {
        $idProdi = auth()->user()->ID_PRODI;
        $matkul = DB::table('Matakuliah')
            ->select('Matakuliah.ID_MATAKULIAH')
            ->join('Kelas', 'Kelas.ID_MATAKULIAH', '=', 'Matakuliah.ID_MATAKULIAH')
            ->join('Users', 'Users.ID_USER', '=', 'Kelas.ID_USER')
            ->where('Users.ID_PRODI', '=', $idProdi)->distinct('Matakuliah.ID_MATAKULIAH')->pluck('ID_MATAKULIAH');

        $cpl = DB::table('Cpl_Matakuliah')
            ->join('Cpl','Cpl.ID_CPL','=','Cpl_Matakuliah.ID_CPL')
            ->where('Cpl.ID_PRODI','=',$idProdi)
            ->select('Cpl.KD_CPL')->distinct('KD_CPL')->get();

        $hasil = [];
        $bobot = 0;
        $namaMatkul = "";
        foreach ($cpl as $c) {
            $findMatkul = DB::table('Cpl_Matakuliah')
                ->select('Matakuliah.SINGKATAN_MATKUL', 'BOBOT')
                ->join('Matakuliah', 'Matakuliah.ID_MATAKULIAH', '=', 'Cpl_Matakuliah.ID_MATAKULIAH')
                ->join('Cpl','Cpl.ID_CPL','=','Cpl_Matakuliah.ID_CPL')
                ->where('Cpl.ID_PRODI','=',$idProdi)
                ->where('Cpl.KD_CPL', '=', $c->KD_CPL)
                ->whereIn('Cpl_Matakuliah.ID_MATAKULIAH', $matkul)->get();
            $bobot = 0;
            $namaMatkul = "";
            for ($i = 0; $i < count($findMatkul); $i++) {
                $bobot += $findMatkul[$i]->BOBOT;

                if ($i == 0) {
                    $namaMatkul = $findMatkul[$i]->SINGKATAN_MATKUL;
                } else {
                    $namaMatkul = $namaMatkul." , " . $findMatkul[$i]->SINGKATAN_MATKUL;
                }
            }
            $hasil[] = [
                'ID' => $c->KD_CPL,
                'NAMA' => $namaMatkul,
                'JMLH' => count($findMatkul),
                'NILAI' => $bobot,
            ];
        }
        return view('cpl_prodi.cplmatkul',['hasil' => $hasil]);
    }
}
