<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory, Filterable;

    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters)
    {
        // filterable
        $searchableColumns = ['question'];
        $validSortColumns = ['question', 'created_at'];
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

    public function studentAnswer()
    {
        return $this->hasOne(StudentAnswer::class);
    }
}
