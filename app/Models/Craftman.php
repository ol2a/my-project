<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Craftman extends Model
{
    use HasFactory;

    protected $table = 'craftmen';

    protected $fillable = ['name' , 'email' ,'address' , 'national_id','phone_numper'];

    public $timestamps = true;
}
