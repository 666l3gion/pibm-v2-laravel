<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory, Filterable;

    protected $guarded = ['id'];
    protected $perPage = 20;

    public function scopeFilter($query, array $filters)
    {
        // filterable
        $searchableColumns = ['nip', 'name', 'email'];
        $validSortColumns = ['nip', 'name', 'email', 'created_at'];
        $this->setFilterableProperties($searchableColumns, $validSortColumns);
        $this->filter($query, $filters);
    }

    /**
     * untuk mendapatkan data guru yang hanya memiliki kelas
     */
    public function scopeExistsOnClassTeacher($query)
    {
        return $query->with(['classes'])->whereHas("classes");
    }

    // many-to-many
    public function classes()
    {
        // tiga parameter berguna untuk mengatasi nama table class dan modelnya agar bisa dikenali oleh laravel
        return $this->belongsToMany(Clazss::class, 'class_teacher', 'teacher_id', 'class_id');
    }
}
