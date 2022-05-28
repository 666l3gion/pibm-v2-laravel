<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamType extends Model
{
    use HasFactory, Filterable;

    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters)
    {
        // filterable
        $searchableColumns = ['name'];
        $validSortColumns = ['name', 'created_at'];
        $this->setFilterableProperties($searchableColumns, $validSortColumns);
        $this->filter($query, $filters);
    }
}
