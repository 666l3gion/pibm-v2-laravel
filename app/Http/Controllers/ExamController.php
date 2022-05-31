<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExamRequests\ExamRequest;
use Illuminate\Support\Str;
use App\Models\Exam;
use App\Models\ExamType;
use App\Models\Question;
use App\Models\Student;
use App\Models\StudentAnswer;
use App\Models\Teacher;
use Illuminate\Http\Request;

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

    public function sheet(Exam $exam)
    {
        $this->authorize('sheet', $exam);
        // cek apakah ujian sedang berlansung, jika tidak throw halaman error dengan code forbidden
        if (strtotime($exam->start_date) > time() || strtotime($exam->end_date) < time())
            abort(403, 'Ujian belum dimulai atau ujian sudah berakhir');
        // TODO: implement cek apakah sudah mengikuti ujian

        $exam->load(['subject', 'class', 'teacher']);
        // ambil siswa yang mengikuti ujian ssat ini
        $student = Student::query()->where('user_id', '=', auth()->user()->id)->first();
        // ambil soal dengan mata pelajaran dan guru dari ujian saat ini
        $questions = Question::query()
            ->where('teacher_id', '=', $exam->teacher->id)
            ->where('subject_id', '=', $exam->subject->id)
            ->where('exam_type_id', '=', $exam->exam_type_id)
            ->with(['studentAnswer'])
            ->limit($exam->total_question)
            ->get();

        return view('exams.sheet', [
            "pretitle" => "Ujian",
            "title" => "Lembar Ujian",
            "exam" => $exam,
            'student' => $student,
            'questions' => $questions
        ]);
    }

    public function saveOneQuestion(Request $request, Exam $exam)
    {
        $this->authorize('sheet', $exam);
        if (strtotime($exam->start_date) > time() || strtotime($exam->end_date) < time())
            abort(403, 'Ujian belum dimulai atau ujian sudah berakhir');

        $idQuestion = $request->post('idQuestion');
        $option = $request->post('option');

        // cek apakah idQuestion dan user id sudah ada di student_answers
        // jika belum insert
        // jika sudah update
        $studentAnswer = StudentAnswer::updateOrCreate([
            "user_id" => auth()->user()->id,
            "question_id" => $idQuestion
        ], [
            "answer" => $option
        ]);

        return ['success' => true, 'studentAnswer' => $studentAnswer];
    }

    public function saveExam(Request $request, Exam $exam)
    {
        // handle jika siswa selesai pada saat waktu ujian habis
        dd($request);
    }
}
