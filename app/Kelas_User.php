<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelas_User extends Model
{
    protected $table = 'Kelas_Users';
    protected $primaryKey = 'ID_KELAS_USER';
    public $incrementing = false;
    protected $fillable = [
        'ID_KELAS_USER','ID_KELAS','ID_USER'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
