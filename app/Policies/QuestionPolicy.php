<?php

namespace App\Policies;

use App\Models\Question;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuestionPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function create(User $user)
    {
        return $user->isTeacher();
    }

    /**
     * updateOrDelete agar mengurangi query pada saat memanggil @can di index.blade.php
     * karena isi dari update dan delete sama saja
     */
    public function updateOrDelete(User $user, Question $question)
    {
        $teacher = Teacher::find($question->teacher_id);
        return $user->isTeacher() && $user->id == $teacher->user_id;
    }

    // public function delete(User $user, Question $question)
    // {
    //     $teacher = Teacher::find($question->teacher_id);
    //     return $user->isTeacher() && $user->id == $teacher->user_id;
    // }
}
