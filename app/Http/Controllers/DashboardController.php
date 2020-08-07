<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;
use \App\Matakuliah;
use \App\Kelas;
use \App\Cpl;
use \App\Kelas_User;
use \App\Prodi;
use \App\Cpl_Matakuliah;
use Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $status = auth()->user()->status->NAMA_STATUS;
        if ($status == "Admin") {
            return $this->admin();
        } elseif ($status == "Dosen") {
            return $this->dosen();
        } elseif ($status == "Mahasiswa") {
            return $this->mahasiswa();
        } else {
            return $this->kaprodi();
        }
    }

    public function dashKaprodiDosen()
    {
        return $this->dosen();
    }

    public function admin()
    {
        $data['jmlhuser'] = User::all()->count();
        $data['jmlhmat'] = Matakuliah::all()->count();
        $data['jmlhkel'] = Kelas::all()->count();
        $data['jmlhcpl'] = Cpl::all()->count();
        //Kelas Get Data
        $prodi = Prodi::all();

        $jmlhKelas = [];

        foreach ($prodi as $prd) {
            $kelas = DB::table('Kelas')
                ->join('Users', 'Users.ID_USER', '=', 'Kelas.ID_USER')
                ->where('Users.ID_PRODI', '=', $prd->ID_PRODI)->count();

            $jmlhKelas[] = [
                'SINGKATAN' => $prd->SINGKATAN_PRODI,
                'JUMLAH' => $kelas,
            ];
        }

        $prodiData = [];
        $prodiMhs = [];

        foreach ($jmlhKelas as $jml) {
            $prodiData[] = $jml['SINGKATAN'];
            $prodiMhs[] = $jml['JUMLAH'];
        }

        $data['prodiData'] = json_encode($prodiData);
        $data['prodiMhs'] = json_encode($prodiMhs);

        return view('dashboard.admin', ['data' => $data]);
    }

    public function kaprodi()
    {
        $idProdi = auth()->user()->ID_PRODI;
        $prodi = Prodi::find($idProdi);

        $data['jmlhuser'] = User::whereIdProdi($idProdi)->count();
        $data['jmlhmatkul'] = DB::table('Matakuliah')
            ->join('Kelas', 'Kelas.ID_MATAKULIAH', '=', 'Matakuliah.ID_MATAKULIAH')
            ->join('Users', 'Users.ID_USER', '=', 'Kelas.ID_USER')
            ->where('Users.ID_PRODI', '=', $idProdi)->distinct('Matakuliah.ID_MATAKULIAH')->count();

        $data['jmlhkelas'] = DB::table('Kelas')
            ->join('Users', 'Users.ID_USER', '=', 'Kelas.ID_USER')
            ->where('Users.ID_PRODI', '=', $idProdi)->count();

        $avgBobot = DB::table('Matakuliah')
            ->join('Kelas', 'Kelas.ID_MATAKULIAH', '=', 'Matakuliah.ID_MATAKULIAH')
            ->join('Users', 'Users.ID_USER', '=', 'Kelas.ID_USER')
            ->join('Cpl_Matakuliah', 'Cpl_Matakuliah.ID_MATAKULIAH', '=', 'Matakuliah.ID_MATAKULIAH')
            ->where('Users.ID_PRODI', '=', $idProdi)->avg('Cpl_Matakuliah.BOBOT');

        $data['avgbobotcpl'] = round($avgBobot, 2);

        //Get Nilai CPL
     
        $kelas = DB::table('Kelas')
            ->select('ID_MATAKULIAH')
            ->join('Users', 'Users.ID_USER', '=', 'Kelas.ID_USER')
            ->where('Users.ID_PRODI', '=', $idProdi)
            ->distinct('ID_MATAKULIAH')->get();
        $bobotcpl = [];
        $dataCpl = [];
        foreach ($kelas as $kls) {
            $cplmatkul = round(DB::table('Cpl_Matakuliah')->where('ID_MATAKULIAH', '=', $kls->ID_MATAKULIAH)->avg('BOBOT'), 2);


            $matkulCpl = Matakuliah::find($kls->ID_MATAKULIAH);



            $dataCpl[] = [
                'ID' => $kls->ID_MATAKULIAH,
                'NAMA' => $matkulCpl->SINGKATAN_MATKUL,
                'NILAI' => $cplmatkul,
            ];
        }


        //Show Top 3
        $arraySortTop = collect($dataCpl)->sortBy('NILAI')->reverse()->take(3);


         //Get Beban Mahasiswa Setiap Kelas
      
        $mytime = Carbon\Carbon::now();

        $klsdosen = DB::table('Kelas')
            ->select('Kelas.ID_MATAKULIAH', 'Kelas.ID_KELAS', 'Kelas.GRUP')
            ->join('Users', 'Users.ID_USER', '=', 'Kelas.ID_USER')
            ->where('Users.ID_PRODI', '=', $idProdi)
            ->distinct('ID_MATAKULIAH')->get();
        $countMhs = 0;
        $listKelasFinal = [];

        foreach ($klsdosen as $k) {
            $klsmhs = Kelas_User::whereIdKelas($k->ID_KELAS)->get();

            $countMhs = 0;
            $rataMhs = 0;
            foreach ($klsmhs as $m) {
                $listKelas = DB::table('Kelas_Users')
                    ->select('Users.ID_USER', 'Users.NAMA', 'Tugas.PERSEN', 'Tugas.WAKTU_MULAI', 'Tugas.WAKTU_SELESAI', 'Kelas_Users.ID_KELAS')
                    ->join('Tugas', 'Tugas.ID_KELAS', '=', 'Kelas_Users.ID_KELAS')
                    ->join('Users', 'Users.ID_USER', '=', 'Kelas_Users.ID_USER')
                    ->where('Kelas_Users.ID_USER', '=', $m->ID_USER)
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

                    $bobotPerTugas[] = round((($bobotWaktu * $prodi->BOBOT_WAKTU) + ($bobotPersen * $prodi->BOBOT_PERSEN) + ($cpl * $prodi->BOBOT_CPL)), 2);

                    //Waktu Kumpul Tugas Terdekat

                    // if ($idx == 0) {
                    //     $waktuKumpulTerdekat = Carbon\Carbon::Parse($tgs->WAKTU_SELESAI);
                    // } else {
                    //     if ($waktuKumpulTerdekat->greaterThan($tgs->WAKTU_SELESAI)) {
                    //         $waktuKumpulTerdekat = Carbon\Carbon::Parse($tgs->WAKTU_SELESAI);
                    //     }
                    // }

                    $idx++;
                }
                $bobotPerMhs = 0;
                $countBobotTugas = count($bobotPerTugas);
                for ($i = 0; $i < $countBobotTugas; $i++) {
                    $bobotPerMhs += $bobotPerTugas[$i];
                }

                if ($bobotPerMhs != 0) {
                    $bobotPerMhs = round(($bobotPerMhs / $countBobotTugas), 2);
                }


                $rataMhs += $bobotPerMhs;

                $countMhs++;
            }
            if ($countMhs > 0) {
                $rataMhs = round(($rataMhs / $countMhs), 2);
            }

            $findSingkatan = Matakuliah::find($k->ID_MATAKULIAH);
            $listKelasFinal[] = [
                'ID' => $k->ID_MATAKULIAH,
                'NAMA' => $findSingkatan->SINGKATAN_MATKUL . "-" . $k->GRUP,
                'BEBAN' => $rataMhs,
            ];
        }

        //Sort Array Kelas Final Top 3
        $arraySortKelas = collect($listKelasFinal)->sortBy('BEBAN')->reverse()->take(3);


        return view('dashboard.kaprodi', ['data' => $data, 'sortTopCpl' => json_encode($arraySortTop), 'sortTop' => json_encode($arraySortKelas), 'listKelas' => (collect($listKelasFinal)), 'listCpl' => collect($dataCpl)]);
    }



    public function dosen()
    {
        //$idUser = auth()->user()->ID_USER;
        $idProdi = auth()->user()->ID_PRODI;
        $prodi = Prodi::find($idProdi);
        $mytime = Carbon\Carbon::now();

        $data['jmlhkelas'] = Kelas::where(function ($query) {
            $query->where('ID_USER', '=', auth()->user()->ID_USER)
                ->orWhere('ID_USER1', '=', auth()->user()->ID_USER)
                ->orWhere('ID_USER2', '=', auth()->user()->ID_USER);
        })->count();
        $data['jmlhmhs'] = DB::table('Kelas_Users')
            ->whereIn('ID_KELAS', DB::table('Kelas')->select('ID_KELAS')->where(function ($query) {
                $query->where('ID_USER', '=', auth()->user()->ID_USER)
                    ->orWhere('ID_USER1', '=', auth()->user()->ID_USER)
                    ->orWhere('ID_USER2', '=', auth()->user()->ID_USER);
            }))->count();


        $data['tgsaktif'] = DB::table('Tugas')
            ->where('WAKTU_SELESAI', '>', $mytime)
            ->whereIn('ID_KELAS', DB::table('Kelas')->select('ID_KELAS')->where(function ($query) {
                $query->where('ID_USER', '=', auth()->user()->ID_USER)
                    ->orWhere('ID_USER1', '=', auth()->user()->ID_USER)
                    ->orWhere('ID_USER2', '=', auth()->user()->ID_USER);
            }))->count();

        //Get Nilai CPL

        $kelas = DB::table('Kelas')
            ->select('ID_MATAKULIAH')
            ->where(function ($query) {
                $query->where('ID_USER', '=', auth()->user()->ID_USER)
                    ->orWhere('ID_USER1', '=', auth()->user()->ID_USER)
                    ->orWhere('ID_USER2', '=', auth()->user()->ID_USER);
            })
            ->distinct('ID_MATAKULIAH')->get();
        $sortTop = [];
        foreach ($kelas as $kls) {
            $cplmatkul = round(DB::table('Cpl_Matakuliah')->where('ID_MATAKULIAH', '=', $kls->ID_MATAKULIAH)->avg('BOBOT'), 2);

            $matkulCpl = Matakuliah::find($kls->ID_MATAKULIAH);

            $sortTop[] = [
                'ID' =>  $kls->ID_MATAKULIAH,
                'NAMA' => $matkulCpl->SINGKATAN_MATKUL,
                'NILAI' => $cplmatkul,
            ];
        }
        //Show Top 3
        $arraySortTop = collect($sortTop)->sortBy('NILAI')->reverse()->take(3);




        //Get Beban Mahasiswa Setiap Kelas
        $data['kelasData'] = "[]";
        $data['kelasBobot'] = "[]";


        $klsdosen = Kelas::where(function ($query) {
            $query->where('ID_USER', '=', auth()->user()->ID_USER)
                ->orWhere('ID_USER1', '=', auth()->user()->ID_USER)
                ->orWhere('ID_USER2', '=', auth()->user()->ID_USER);
        })->get();
        $countMhs = 0;
        $listKelasFinal = [];

        foreach ($klsdosen as $k) {
            $klsmhs = Kelas_User::whereIdKelas($k->ID_KELAS)->get();

            $countMhs = 0;
            $rataMhs = 0;
            foreach ($klsmhs as $m) {
                $listKelas = DB::table('Kelas_Users')
                    ->select('Users.ID_USER', 'Users.NAMA', 'Tugas.PERSEN', 'Tugas.WAKTU_MULAI', 'Tugas.WAKTU_SELESAI', 'Kelas_Users.ID_KELAS')
                    ->join('Tugas', 'Tugas.ID_KELAS', '=', 'Kelas_Users.ID_KELAS')
                    ->join('Users', 'Users.ID_USER', '=', 'Kelas_Users.ID_USER')
                    ->where('Kelas_Users.ID_USER', '=', $m->ID_USER)
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

                    $bobotPerTugas[] = round((($bobotWaktu * $prodi->BOBOT_WAKTU) + ($bobotPersen * $prodi->BOBOT_PERSEN) + ($cpl * $prodi->BOBOT_CPL)), 2);
                   
                    //Waktu Kumpul Tugas Terdekat

                    // if ($idx == 0) {
                    //     $waktuKumpulTerdekat = Carbon\Carbon::Parse($tgs->WAKTU_SELESAI);
                    // } else {
                    //     if ($waktuKumpulTerdekat->greaterThan($tgs->WAKTU_SELESAI)) {
                    //         $waktuKumpulTerdekat = Carbon\Carbon::Parse($tgs->WAKTU_SELESAI);
                    //     }
                    // }

                    $idx++;
                }

                $bobotPerMhs = 0;
                $countBobotTugas = count($bobotPerTugas);
                for ($i = 0; $i < $countBobotTugas; $i++) {
                    $bobotPerMhs += $bobotPerTugas[$i];
                }

                if ($bobotPerMhs != 0) {
                    $bobotPerMhs = round(($bobotPerMhs / $countBobotTugas), 2);
                }

                $rataMhs += $bobotPerMhs;

                $countMhs++;
            }

            if ($countMhs > 0) {
                $tmp = $rataMhs / $countMhs;
                $rataMhs =  round($tmp,2);
                
            }

            $listKelasFinal[] = [
                'ID' => $k->ID_MATAKULIAH,
                'NAMA' => $k->matakuliah->SINGKATAN_MATKUL . "-" . $k->GRUP,
                'BEBAN' => $rataMhs,
            ];
        }



        //Sort Array Kelas Top 3

        $arraySortKelas = collect($listKelasFinal)->sortBy('BEBAN')->reverse()->take(3);

        return view('dashboard.dosen', ['data' => $data, 'sortTop' => json_encode($arraySortKelas), 'sortTopCpl' => json_encode($arraySortTop), 'listCpl' => collect($sortTop), 'listKelas' => collect($listKelasFinal)]);
    }

    public function mahasiswa()
    {
        $idUser = auth()->user()->ID_USER;
        $idProdi = auth()->user()->ID_PRODI;
        $prodi = Prodi::find($idProdi);
        $mytime = Carbon\Carbon::now();

        $data = [];
        $data['jmlhkelas']  = Kelas_User::whereIdUser($idUser)->count();

        //Get Rata Bobot Mahasiswa
        $data['rataBobot'] = 0;

        $listKelas = DB::table('Kelas_Users')
            ->select('Users.ID_USER', 'Users.NAMA', 'Tugas.PERSEN', 'Tugas.WAKTU_MULAI', 
            'Tugas.WAKTU_SELESAI', 'Kelas_Users.ID_KELAS')
            ->join('Tugas', 'Tugas.ID_KELAS', '=', 'Kelas_Users.ID_KELAS')
            ->join('Users', 'Users.ID_USER', '=', 'Kelas_Users.ID_USER')
            ->where('Kelas_Users.ID_USER', '=', $idUser)
            ->where('Tugas.WAKTU_SELESAI', '>', $mytime)->get();
        $bobotPerTugas = [];
        $idx = 0;
        //Waktu Kumpul Tugas Terdekat
        $waktuKumpulTerdekat = $mytime;
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

            $bobotPerTugas[] = round((($bobotWaktu * $prodi->BOBOT_WAKTU) + 
            ($bobotPersen * $prodi->BOBOT_PERSEN) + 
            ($cpl * $prodi->BOBOT_CPL)), 2);

            
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


        if ($countBobotTugas > 0) {
            $data['rataBobot'] = round(($bobotPerMhs / $countBobotTugas), 2);
            $data['tugasTerdekat'] = $waktuKumpulTerdekat;
        } else {
            $data['rataBobot'] = 0;
            $data['tugasTerdekat'] = "-";
        }

        //Jumlah Tugas Aktif
        $tugasAktif = DB::table('Tugas')
            ->select('Tugas.NAMA_TUGAS', 'Tugas.PERSEN', 'Tugas.WAKTU_SELESAI', 'Kelas.ID_MATAKULIAH', 'Kelas.GRUP')
            ->join('Kelas', 'Kelas.ID_KELAS', '=', 'Tugas.ID_KELAS')
            ->where('WAKTU_SELESAI', '>', $mytime)
            ->whereIn('Tugas.ID_KELAS', DB::table('Kelas_Users')->select('ID_KELAS')->where('ID_USER', '=', $idUser))->get();

        for ($i = 0; $i < count($tugasAktif); $i++) {
            $sisaPengerjaan = $mytime->diffInDays($tugasAktif[$i]->WAKTU_SELESAI);
            $tgsMatkul = Matakuliah::find($tugasAktif[$i]->ID_MATAKULIAH);
            $tugasAktif[$i]->SELISIH = $sisaPengerjaan;
            $tugasAktif[$i]->NAMA = $tgsMatkul->SINGKATAN_MATKUL . "-" . $tugasAktif[$i]->GRUP;
        }
        $data['tugasaktif'] = count($tugasAktif);

        return view('dashboard.mahasiswa', ['data' => $data, 'tugas' => json_encode($tugasAktif)]);
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
