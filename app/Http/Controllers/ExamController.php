<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExamRequests\ExamRequest;
use Illuminate\Support\Str;
use App\Models\Exam;
use App\Models\ExamType;
use App\Models\Student;
use App\Models\Teacher;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::query()->with(['teacher', 'subject', 'class'])
            ->filter(request(['search', 'sort', 'direction']))
            ->paginate()
            ->withQueryString();

        return view('exams.index', [
            "pretitle" => "Ujian",
            "title" => "Data Ujian",
            "exams" => $exams
        ]);
    }

    public function create()
    {
        $this->authorize('create', Exam::class);
        $teacher = Teacher::query()
            ->where('user_id', '=', auth()->user()->id)
            ->with(['subjects', 'classes'])
            ->first();
        $examTypes = ExamType::all();

        return view('exams.create', [
            "pretitle" => "Ujian",
            "title" => "Tambah Data Ujian",
            'teacher' => $teacher,
            "examTypes" => $examTypes
        ]);
    }

    // hanya bisa diakses oleh siswa
    public function show(Exam $exam)
    {
        $this->authorize('view', $exam);
        $exam->load(['subject', 'class', 'teacher']);
        $student = Student::query()->where('user_id', '=', auth()->user()->id)->first();

        return view('exams.show', [
            "pretitle" => "Ujian",
            "title" => "Detail Data Ujian",
            "exam" => $exam,
            'student' => $student
        ]);
    }

    public function store(ExamRequest $request)
    {
        $this->authorize('create', Exam::class);
        $validatedData = $request->validated();
        $validatedData['token'] = Str::random(5);
        Exam::create($validatedData);
        return redirect()->route("exams.index")->with('success', 'Data ujian berhasil ditambahkan.');
    }

    public function edit(Exam $exam)
    {
        $this->authorize('update', $exam);
        $teacher = Teacher::query()
            ->where('user_id', '=', auth()->user()->id)
            ->with(['subjects', 'classes'])
            ->first();
        $examTypes = ExamType::all();

        return view('exams.edit', [
            "pretitle" => "Ujian",
            "title" => "Edit Data Ujian",
            'teacher' => $teacher,
            'exam' => $exam,
            "examTypes" => $examTypes
        ]);
    }

    public function update(ExamRequest $request, Exam $exam)
    {
        $this->authorize('update', $exam);
        $exam->update($request->validated());
        return redirect()->route("exams.index")->with('success', 'Data ujian berhasil diubah.');
    }

    public function destroy(Exam $exam)
    {
        $this->authorize('delete', $exam);
        $exam->delete();
        return redirect()->route('exams.index')->with('success', 'Data ujian berhasil dihapus.');
    }
}
