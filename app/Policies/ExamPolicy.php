<?php

namespace App\Policies;

use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;

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
        $examResult = ExamResult::query()->where([
            "user_id" => $user->id,
            "exam_id" => $exam->id
        ])->first();
        $isUserOrStudentTakeAndFinishTheExam = $examResult ? $examResult->status : false;
        return $user->isStudent() && $student->classes->contains('id', $exam->class_id) && !$isUserOrStudentTakeAndFinishTheExam; // !$isUserOrStudentTakeAndFinishTheExam === belum menyelesaikan ujian
    }

    // kenapa diberi nama updateOrDelete, karena isi dari update dan delete sama saja
    // jadi untuk peformance pada saat mengunakan @can di loop exams/index.blade.php tidak query dua kali
    public function updateOrDelete(User $user, Exam $exam)
    {
        $teacher = Teacher::find($exam->teacher_id);
        return $user->isTeacher() && $user->id == $teacher->user_id;
    }

    // public function delete(User $user, Exam $exam)
    // {
    //     $teacher = Teacher::find($exam->teacher_id);
    //     return $user->isTeacher() && $user->id == $teacher->user_id;
    // }

    public function sheet(User $user, Exam $exam)
    {
        $student = Student::query()
            ->where('user_id', '=', auth()->user()->id)
            ->with(['classes'])
            ->first();
        // cek apakah yang mengkases detail adalah siswa dan siswa tersebut berelasi ke kelas dari ujian ini
        return $user->isStudent()
            && $student->classes->contains('id', $exam->class_id);
    }

    /**
     * Hampir sama seperti view, hanya yang beda tidak ada ! $isUserOrStudentTakeAndFinishTheExam
     */
    public function result(User $user, Exam $exam, ExamResult $examResult)
    {
        $student = Student::query()->where('user_id', '=', $user->id)->with(['classes'])->first();
        // cek apakah yang mengkases detail adalah siswa dan siswa tersebut berelasi ke kelas dari ujian ini
        $isUserOrStudentTakeAndFinishTheExam = $examResult ? $examResult->status : false;
        return $user->isStudent() && $student->classes->contains('id', $exam->class_id) && $isUserOrStudentTakeAndFinishTheExam; // $isUserOrStudentTakeAndFinishTheExam === sudah menyelesaikan ujian
    }
}
