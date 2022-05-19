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
    protected $table = "classes";

    public function scopeFilter($query, array $filters)
    {
        // filterable
        $searchableColumns = ['name'];
        $validSortColumns = ['name', 'created_at'];
        $this->setFilterableProperties($searchableColumns, $validSortColumns, 'asc');
        $this->filter($query, $filters);
    }

    /**
     * untuk mendapatkan data kelas yang hanya ada di table class_student
     */
    public function scopeExistsOnClassStudent($query)
    {
        return $query->with(['students'])->whereHas("students");
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

    // many-to-many
    public function students()
    {
        // tiga parameter berguna untuk mengatasi nama table class dan modelnya agar bisa dikenali oleh laravel
        return $this->belongsToMany(Student::class, 'class_student', 'class_id', 'student_id');
    }
}
