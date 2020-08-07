<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matakuliah extends Model
{
    protected $table = 'Matakuliah';
    protected $primaryKey = 'ID_MATAKULIAH';
    public $incrementing = false;
    protected $fillable = [
        'ID_MATAKULIAH','NAMA_MATAKULIAH','SKS','SINGKATAN_MATKUL'
    ];
    
    public function kelas(){
        return $this->hasMany(Kelas::class);
    }

}
