<?php

namespace App\Http\Controllers;

use App\Models\Clazss;
use App\Models\ExamType;
use App\Models\Major;
use App\Models\Question;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index', [
            "title" => "Dashboard",
            "teacher_count" => Teacher::count(),
            "student_count" => Student::count(),
            "user_count" => User::count(),
            "question_count" => Question::count(),
            "major_count" => Major::count(),
            "exam_type_count" => ExamType::count(),
            "subject_count" => Subject::count(),
            "class_count" => Clazss::count(),
        ]);
    }
}
