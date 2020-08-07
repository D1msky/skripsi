<?php

namespace App\Http\Controllers;

use App\Cpl_Matakuliah;
use Illuminate\Http\Request;
use \App\Kelas;
use \App\Kelas_User;
use App\Prodi;
use \App\Tugas;
use Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class BobotController extends Controller
{
    public function index($id)
    {
        try {
            //Proteksi Get Kelas 

            $cek = Kelas::where(function ($query) {
                $query->where('ID_USER', '=', auth()->user()->ID_USER)
                    ->orWhere('ID_USER1', '=', auth()->user()->ID_USER)
                    ->orWhere('ID_USER2', '=', auth()->user()->ID_USER);
            })->where('ID_KELAS', '=', $id)->count();
            if ($cek == 0) {
                return redirect('/');
            } else {
                $kelas = Kelas::find($id);
                return view('bobot.index', ['kelas' => $kelas]);
            }
        } catch (\Exception $e) {

            return redirect('/');
        }
    }

    public function getBobot(Request $request)
    {
        $idProdi = auth()->user()->ID_PRODI;
        $prodi = Prodi::find($idProdi);

        $input = $request->all();
        $mytime = Carbon\Carbon::now();
        $mhs = DB::table('Kelas_Users')
            ->select('Users.ID_USER', 'Users.NAMA')
            ->join('Users', 'Users.ID_USER', '=', 'Kelas_Users.ID_USER')
            ->where('ID_KELAS', '=', $input['idKelas'])->get();


        $hasil = [];
        $bobotPerTugas = 0;
        foreach ($mhs as $data) {
            $listKelas = DB::table('Kelas_Users')
                ->select('Users.ID_USER', 'Users.NAMA', 'Tugas.PERSEN', 'Tugas.WAKTU_MULAI', 'Tugas.WAKTU_SELESAI', 'Kelas_Users.ID_KELAS')
                ->join('Tugas', 'Tugas.ID_KELAS', '=', 'Kelas_Users.ID_KELAS')
                ->join('Users', 'Users.ID_USER', '=', 'Kelas_Users.ID_USER')
                ->where('Kelas_Users.ID_USER', '=', $data->ID_USER)
                ->where('Tugas.WAKTU_SELESAI', '>', $mytime)->get();

            $bobotPerTugas = [];
            $idx = 0;
            
            foreach ($listKelas as $tgs) {
                $matkul = Kelas::find($tgs->ID_KELAS);
                $cpl = round(Cpl_Matakuliah::whereIdMatakuliah($matkul->ID_MATAKULIAH)->avg('BOBOT'), 2);

                $waktuMulai = Carbon\Carbon::Parse($tgs->WAKTU_MULAI);
                $selisihWaktu = $waktuMulai->diffInSeconds($tgs->WAKTU_SELESAI);
                $waktuBerjalan = $mytime->diffInSeconds($tgs->WAKTU_MULAI);
                $persenBerjalan = round(($waktuBerjalan / $selisihWaktu) * 100, 2); //Persen Waktu Berjalan
                $bobotWaktu = 0;
                $bobotWaktu = $this->cekPersen($persenBerjalan);

                $prsnTgs = $tgs->PERSEN;
                $bobotPersen = 0;
                $bobotPersen = $this->cekTugas($prsnTgs, $prodi);

                $bobotPerTugas[] = round((($bobotWaktu * $prodi->BOBOT_WAKTU) + ($bobotPersen * $prodi->BOBOT_PERSEN) + ($cpl * $prodi->BOBOT_CPL)) , 2);

                //Waktu Kumpul Tugas Terdekat
                $waktuKumpulTerdekat = $mytime;
                if ($idx == 0) {
                    $waktuKumpulTerdekat = Carbon\Carbon::Parse($tgs->WAKTU_SELESAI);
                } else {
                    if ($waktuKumpulTerdekat->greaterThan($tgs->WAKTU_SELESAI)) {
                        $waktuKumpulTerdekat = Carbon\Carbon::Parse($tgs->WAKTU_SELESAI);
                    }
                }

                $idx++;
            }

            $bobotPerMhs = 0;
            $countBobotTugas = count($bobotPerTugas);
            for ($i = 0; $i < $countBobotTugas; $i++) {
                $bobotPerMhs += $bobotPerTugas[$i];
            }

            if ($bobotPerMhs != 0) {
                $bobotPerMhs = round(($bobotPerMhs / $countBobotTugas), 2);
                $hasil[] = [
                    'ID_USER' => $data->ID_USER,
                    'NAMA' => $data->NAMA,
                    'BOBOT' => $bobotPerMhs,
                    'KUMPUL_TERDEKAT' => $waktuKumpulTerdekat->format('d/m/Y H:i:s'),
                ];
            }else{
                $hasil[] = [
                    'ID_USER' => $data->ID_USER,
                    'NAMA' => $data->NAMA,
                    'BOBOT' => $bobotPerMhs,
                    'KUMPUL_TERDEKAT' => "-",
                ];
            }
           
        }

        return response()->json($hasil);
    }

    public function cekPersen($persenBerjalan)
    {
        if ((($persenBerjalan >= 0) && ($persenBerjalan < 10)) || (($persenBerjalan >= 90) && ($persenBerjalan <= 100))) {
            //Sangat Rendah
            return 1;
        } elseif ((($persenBerjalan >= 10) && ($persenBerjalan < 20)) || (($persenBerjalan >= 80) && ($persenBerjalan < 90))) {
            //Rendah
            return 2;
        } elseif ((($persenBerjalan >= 20) && ($persenBerjalan < 40)) || (($persenBerjalan >= 60) && ($persenBerjalan < 80))) {
            //Sedang
            return 3;
        } else {
            //Tinggi
            return 4;
        }
    }

    public function cekTugas($prsnTgs, $prodi)
    {
        if ($prsnTgs >= $prodi->PERSEN_TINGGI) {
            //Tinggi
            return 4;
        } elseif (($prsnTgs >= $prodi->PERSEN_SDG_A) && ($prsnTgs < $prodi->PERSEN_SDG_B)) {
            //Sedang
            return 3;
        } elseif (($prsnTgs >= $prodi->PERSEN_RNDH_A) && ($prsnTgs < $prodi->PERSEN_RNDH_B)) {
            //Rendah
            return 2;
        } elseif (($prsnTgs >= $prodi->PERSEN_SRNDH_A) && ($prsnTgs < $prodi->PERSEN_SRNDH_B)) {
            //Sangat Rendah
            return 1;
        }
    }
}
