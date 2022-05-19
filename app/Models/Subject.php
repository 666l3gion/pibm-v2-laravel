<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory, Filterable;

    protected $guarded = ['id'];
    protected $perPage = 20;

    public function scopeFilter($query, array $filters)
    {
        // filterable
        $searchableColumns = ['name'];
        $validSortColumns = ['name', 'created_at'];
        $this->setFilterableProperties($searchableColumns, $validSortColumns);
        $this->filter($query, $filters);
    }

    /**
     * untuk mendapatkan data mapel yang hanya ada di table major_subject
     */
    public function scopeExistsOnMajorSubject($query)
    {
        return $query->with(['majors'])->whereHas("majors");
    }

    /**
     * untuk mendapatkan data mapel yang hanya ada di table subject_teacher
     */
    public function scopeExistsOnTeacherMajor($query)
    {
        return $query->with(['teachers'])->whereHas("teachers");
    }

    // many-to-many
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class);
    }

    // many-to-many
    public function majors()
    {
        return $this->belongsToMany(Major::class);
    }
}
