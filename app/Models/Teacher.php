<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $perPage = 20;

    public function scopeFilter($query, array $filters)
    {
        $query->when(
            $filters['searchKeyword'] ?? false,
            fn ($query, $search) =>
            $query->where([
                ["name", "like", '%' . $search . '%'],
                ["email", "like", '%' . $search . '%'],
            ])
        );
    }
}
