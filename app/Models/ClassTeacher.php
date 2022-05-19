<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ClassTeacher extends Pivot
{
    use HasFactory;

    protected $guarded = ['id'];

    public function classes()
    {
        return $this->belongsTo(Clazss::class, 'class_id', 'id');
    }

    public function teachers()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'id');
    }
}
