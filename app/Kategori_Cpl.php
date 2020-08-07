<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategori_Cpl extends Model
{
    protected $table = 'Kategori_Cpl';
    public $incrementing = false;
    protected $primaryKey = 'ID_KATEGORI_CPL';
    protected $fillable = ['ID_KATEGORI_CPL','NAMA_KATEGORI'];
}
