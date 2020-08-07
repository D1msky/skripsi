<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prodi extends Model
{
    protected $table = 'Prodi';
    protected $primaryKey = 'ID_PRODI';
    public $incrementing = false;
    protected $fillable = [
        'ID_PRODI','ID_FAKULTAS','NAMA_PRODI','EMAIL_PRODI','PERSEN_TINGGI','PERSEN_SDG_A','PERSEN_SDG_B','PERSEN_RNDH_A','PERSEN_RNDH_B','PERSEN_SRNDH_A','PERSEN_SRNDH_B','BOBOT_PERSEN','BOBOT_WAKTU','BOBOT_CPL','SINGKATAN_PRODI'
    ];

    public function user(){
        return $this->hasMany(User::class,'ID_PRODI');
    }

    
}
