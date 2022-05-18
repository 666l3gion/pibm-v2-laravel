<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clazss extends Model
{
    use HasFactory, Filterable;

    protected $guarded = ['id'];
    protected $perPage = 20;
    protected $with = ['major'];
    protected $table = "classes";

    public function scopeFilter($query, array $filters)
    {
        // filterable
        $searchableColumns = ['name'];
        $validSortColumns = ['name', 'created_at'];
        $this->setFilterableProperties($searchableColumns, $validSortColumns);
        $this->filter($query, $filters);
    }

    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    // many-to-many
    public function teachers()
    {
        // tiga parameter berguna untuk mengatasi nama table class dan modelnya agar bisa dikenali oleh laravel
        return $this->belongsToMany(Teacher::class, 'class_teacher', 'class_id', 'teacher_id');
    }
}
