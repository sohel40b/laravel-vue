<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SimpleCrud extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'simple_cruds';
    
    protected $dates = ['deleted_at'];

    protected $fillable = ['name','email','image','gender','skills'];
}
