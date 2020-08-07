<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use Notifiable;
   
    protected $primaryKey = 'ID_USER';
    public $incrementing = false;
 
    protected $fillable = [
        'ID_USER','NAMA', 'PASSWORD', 'JENIS_KELAMIN','ID_STATUS','ID_PRODI','PASSWORD'
    ];

    protected $hidden = [
        'PASSWORD',
    ];

    public function status(){
        return $this->belongsTo(Status::class,'ID_STATUS');
    }

    public function prodi(){
        return $this->belongsTo(Prodi::class,'ID_PRODI');
    }
    
    public function getAuthPassword()
    {
        return $this->PASSWORD;
    }

   
    
}
