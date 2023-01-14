<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimpleCrud extends Model
{
    use HasFactory;

    protected $fillable = ['name','email','image','gender','skills'];
}
