<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    protected $table = 'Fakultas';
    public $incrementing = false;
    protected $primaryKey = 'ID_FAKULTAS';
    protected $fillable = ['ID_FAKULTAS','NAMA_FAKULTAS','EMAIL_FAKULTAS'];
}
