<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clazss extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $perPage = 20;
}
