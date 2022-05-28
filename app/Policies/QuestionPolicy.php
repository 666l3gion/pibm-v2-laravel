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

    public function update(User $user, Question $question)
    {
        $teacher = Teacher::find($question->teacher_id);
        return $user->isTeacher() && $user->id == $teacher->user_id;
    }

    public function delete(User $user, Question $question)
    {
        $teacher = Teacher::find($question->teacher_id);
        return $user->isTeacher() && $user->id == $teacher->user_id;
    }
}
