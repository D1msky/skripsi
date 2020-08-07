<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    protected $table = 'Tugas';
    protected $primaryKey = 'ID_TUGAS';
    public $incrementing = false;
    protected $fillable = ['ID_TUGAS','ID_KELAS','NAMA_TUGAS','PERSEN','WAKTU_MULAI','WAKTU_SELESAI'];

}
