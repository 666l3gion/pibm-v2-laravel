<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory, Filterable;

    protected $guarded = ['id'];
    protected $perPage = 20;

    public function scopeFilter($query, array $filters)
    {
        // filterable
        $searchableColumns = ['name', 'nis', 'email'];
        $validSortColumns = ['name', 'nis', 'email', 'created_at'];
        $this->setFilterableProperties($searchableColumns, $validSortColumns);
        $this->filter($query, $filters);
    }

    // many-to-many
    public function classes()
    {
        // tiga parameter berguna untuk mengatasi nama table class dan modelnya agar bisa dikenali oleh laravel
        return $this->belongsToMany(Clazss::class, 'class_student', 'student_id', 'class_id');
    }
}
