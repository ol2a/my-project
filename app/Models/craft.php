<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class craft extends Model
{
    use HasFactory;
    public function craftman(){
        return $this->hasMany(craftman::class);
    }
}
