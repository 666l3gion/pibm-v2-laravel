<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ExamResultController extends Controller
{
    public function index(Exam $exam)
    {
        // add authorization of $exam->teacher_id === auth()->user()->id
        // FIX eror search input no parameter $exam
        // fix get examResult by teacher id
        $examResults = ExamResult::query()
            ->where(['exam_id' => $exam->id])
            ->with(['student'])
            ->filter(request(['search', 'sort', 'direction']))
            ->paginate()
            ->withQueryString();

        return view('exam-results.index', [
            "pretitle" => "Hasil Ujian",
            "title" => "Data Hasil Ujian",
            "exam" => $exam,
            "examResults" => $examResults
        ]);
    }
}
