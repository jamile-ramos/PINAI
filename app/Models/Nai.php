<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nai extends Model
{
    public function users(){
        return $this->hasMany(User::class, 'idNai');
    }
}
