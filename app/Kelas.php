<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'Kelas';
    public $incrementing = false;
    protected $primaryKey = 'ID_KELAS';
    protected $fillable = ['ID_KELAS','ID_MATAKULIAH','ID_USER','GROUP','SEMESTER','THN_AJARAN','ID_USER1','ID_USER2'];

    public function matakuliah(){
        return $this->belongsTo(Matakuliah::class,'ID_MATAKULIAH');
    }
}
