<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cpl_Matakuliah extends Model
{
    protected $table = 'Cpl_Matakuliah';
    public $incrementing = false;
    protected $primaryKey = 'ID_CPL_MATKUL';
    protected $fillable = ['ID_CPL_MATKUL','ID_CPL','ID_MATAKULIAH','BOBOT'];

    public function cpl(){
        return $this->belongsTo(Cpl::class);
    }
}
