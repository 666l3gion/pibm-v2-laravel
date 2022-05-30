<?php

namespace App\Policies;

use App\Models\Exam;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExamPolicy
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

    public function view(User $user, Exam $exam)
    {
        $student = Student::query()->where('user_id', '=', $user->id)->with(['classes'])->first();
        // cek apakah yang mengkases detail adalah siswa dan siswa tersebut berelasi ke kelas dari ujian ini
        return $user->isStudent() && $student->classes->contains('id', $exam->class_id);
    }

    public function update(User $user, Exam $exam)
    {
        $teacher = Teacher::find($exam->teacher_id);
        return $user->isTeacher() && $user->id == $teacher->user_id;
    }

    public function delete(User $user, Exam $exam)
    {
        $teacher = Teacher::find($exam->teacher_id);
        return $user->isTeacher() && $user->id == $teacher->user_id;
    }
}
