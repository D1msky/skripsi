<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'Status';
    protected $primaryKey = 'ID_STATUS';
    public $incrementing = false;
    protected $fillable = ['ID_STATUS','NAMA_STATUS'];

    public function user(){
        return $this->hasMany(User::class);
    }
}
