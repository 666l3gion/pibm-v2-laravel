<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    use HasFactory, Filterable;

    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters)
    {
        // filterable
        $searchableColumns = ['score', 'total_right_answer'];
        $validSortColumns = ['score', 'total_right_answer', 'start_time', 'end_time', 'created_at'];
        $this->setFilterableProperties($searchableColumns, $validSortColumns);
        $this->filter($query, $filters);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
