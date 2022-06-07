<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory, Filterable;

    protected $guarded = ['id'];

    protected $hidden = [
        'token',
    ];

    public function scopeFilter($query, array $filters)
    {
        // filterable
        $searchableColumns = ['name', 'total_question', 'start_date', 'end_date', 'time'];
        $validSortColumns = ['name', 'total_question', 'start_date', 'end_date', 'time', 'created_at'];
        $this->setFilterableProperties($searchableColumns, $validSortColumns);
        $this->filter($query, $filters);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function class()
    {
        return $this->belongsTo(Clazss::class);
    }

    public function examResults()
    {
        return $this->hasMany(ExamResult::class);
    }
}
