<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => ['auth','CheckStatus:Dosen,Kaprodi']],function(){
   
    Route::get('/tugas/{id}','TugasController@index');

   
    Route::get('/api/tugas/getid','TugasController@getId');
    Route::post('/api/tugas/add','TugasController@add');
    Route::post('/api/tugas/update','TugasController@update');
    Route::post('/api/tugas/delete','TugasController@delete');

    Route::get('/cplmatkul/{id}','Cpl_MatakuliahController@index');
    Route::post('/api/cplmatkul' ,'Cpl_MatakuliahController@getData');
    Route::post('/api/cplmatkul/update','Cpl_MatakuliahController@update');
    Route::post('/api/cplmatkul/delete','Cpl_MatakuliahController@delete');
    Route::get('/cplmatkul/add/{id}','Cpl_MatakuliahController@cpl');
    Route::get('/api/cplmatkul/getid','Cpl_MatakuliahController@getId');
    Route::post('/api/cplmatkul/add','Cpl_MatakuliahController@add');
    Route::post('/api/cplmatkul/add/getdata','Cpl_MatakuliahController@getAddData');

    Route::get('/bobot/{id}','BobotController@index');
    Route::post('/api/bobot','BobotController@getBobot');

    Route::get('/api/filterdosen','MatakuliahController@filterDosen');

});

Route::group(['middleware' => ['auth','CheckStatus:Kaprodi']],function(){
  Route::get('/cplprod','MatakuliahController@cplProdi');
  Route::post('/api/cplprod/getData','MatakuliahController@getMatkulProdi');
  Route::get('/cplprod/show/{id}','Cpl_MatakuliahController@showCplProdi');

  Route::view('/setprodi','prodi.setting');
  Route::get('/api/setprodi','ProdiController@setProdi');
  Route::post('/api/setprodi/update','ProdiController@updateSetProdi');
  Route::get('/cplmatkulprod','Cpl_MatakuliahController@cplMatkulProdi');
  Route::get('/dashdosen','DashboardController@dashKaprodiDosen');

  Route::get('/api/filterkaprodi','MatakuliahController@filterKaprodi');

});



Route::group(['middleware' => ['auth','CheckStatus:Kaprodi,Admin']],function(){
    Route::get('/api/fakultas','FakultasController@index');
    Route::post('/api/prodi/ceksingkatan' ,'ProdiController@cekSingkatan');
});

Route::group(['middleware' => ['auth','CheckStatus:Admin']],function(){
    
    Route::get('/api/user', 'UserController@index');
    Route::post('/api/user/add', 'UserController@add');
    Route::post('/api/user/update','UserController@update');
    Route::post('/api/user/delete','UserController@delete');
    Route::post('/api/user/cekid','UserController@cekId');
    Route::post('/api/user/getmhs','UserController@getMhs');
    Route::get('/api/status' ,'StatusController@index');
    Route::view('/user','user.index');

    
    Route::get('/api/fakultas/getid','FakultasController@getId');
    Route::post('/api/fakultas/add' ,'FakultasController@add');
    Route::post('/api/fakultas/update','FakultasController@update');
    Route::post('/api/fakultas/delete','FakultasController@delete');
    Route::view('/fakultas', 'fakultas.index');


    Route::get('/api/prodi', 'ProdiController@index');
    Route::get('/api/prodi/getid','ProdiController@getid');
    Route::post('/api/prodi/add', 'ProdiController@add');
    Route::post('/api/prodi/update', 'ProdiController@update');
    Route::post('/api/prodi/delete', 'ProdiController@delete');
    
    Route::view('/prodi', 'prodi.index');

    Route::get('/api/matkul','MatakuliahController@index');
    Route::post('/api/matkul/cekid','MatakuliahController@cekId');
    Route::post('/api/matkul/add','MatakuliahController@add');
    Route::post('/api/matkul/update','MatakuliahController@update');
    Route::post('/api/matkul/delete','MatakuliahController@delete');
    Route::post('/api/matkul/ceksingkatan','MatakuliahController@cekSingkatan');
    Route::view('/matakuliah', 'matakuliah.index');


    Route::get('/api/kelas','KelasController@index');

    Route::post('/api/kelas/add','KelasController@add');
    Route::post('/api/kelas/update','KelasController@update');
    Route::post('/api/kelas/delete','KelasController@delete');
    Route::get('/api/kelas/getid','KelasController@getId');
    Route::get('/api/kelas/getthnajaran','KelasController@getThnAjaran');
    Route::post('/api/kelas/cekkelas','KelasController@cekKelas');
    Route::get('/api/user/getdosen','UserController@getDosen');

    Route::view('/kelas', 'kelas.index');

    Route::get('/api/cpl','CplController@index');
    Route::post('/api/cpl/add','CplController@add');
    Route::post('/api/cpl/update','CplController@update');
    Route::post('/api/cpl/delete','CplController@delete');
    Route::get('/api/cpl/getid','CplController@getId');
    Route::get('/api/katcpl', 'Kategori_CplController@index');

    Route::view('/cpl','cpl.index');

    Route::get('/klsuser/{id}' ,'Kelas_UserController@index');
    Route::post('/api/klsuser/getdata','Kelas_UserController@getData');
    Route::get('/api/klsuser/getid','Kelas_UserController@getId');
    Route::post('/api/klsuser/add','Kelas_UserController@add');
    Route::post('/api/klsuser/update','Kelas_UserController@update');
    Route::post('/api/klsuser/delete','Kelas_UserController@delete');
   

    
});


Route::group(['middleware' => ['auth','CheckStatus:Dosen,Admin,Mahasiswa,Kaprodi']],function(){
    Route::get('/','DashboardController@index');
    Route::get('/logout','AuthController@logout');

    Route::get('/dafmatkul','MatakuliahController@dafMatkul');
    Route::get('/tugas/{id}','TugasController@index');
    Route::post('/api/tugas','TugasController@getData');
});


Route::view('/login','session.login')->name('login');

Route::post('/postlogin','AuthController@postlogin');

