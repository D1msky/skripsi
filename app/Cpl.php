<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cpl extends Model
{
    protected $table = 'Cpl';
    public $incrementing = false;
    protected $primaryKey = 'ID_CPL';
    protected $fillable = ['ID_CPL','KD_CPL','ID_PRODI','DESKRIPSI_CPL','ID_KATEGORI_CPL'];

    public function cpl_matakuliah(){
        return $this->hasMany(Cpl_Matakuliah::class);
    }
}
