<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExamRequests\ExamRequest;
use Illuminate\Support\Str;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\ExamType;
use App\Models\Question;
use App\Models\Student;
use App\Models\StudentAnswer;
use App\Models\Teacher;
use Carbon\Carbon;
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
        $this->authorize('updateOrDelete', $exam);
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
        $this->authorize('updateOrDelete', $exam);
        $exam->update($request->validated());
        return redirect()->route("exams.index")->with('success', 'Data ujian berhasil diubah.');
    }

    public function destroy(Exam $exam)
    {
        $this->authorize('updateOrDelete', $exam);
        $exam->delete();
        return redirect()->route('exams.index')->with('success', 'Data ujian berhasil dihapus.');
    }

    public function sheet(Exam $exam)
    {
        $this->authorize('sheet', $exam);

        if ($this->isCannotTakeTheExam($exam)) // jika tidak boleh
            abort(403, 'Ujian belum dimulai atau ujian sudah berakhir');

        $examResult = ExamResult::query()
            ->where('exam_id', '=', $exam->id)
            ->where('user_id', '=', auth()->user()->id)
            ->first();

        if (!$examResult) { //jika kosong/pertama kali
            $examResult = ExamResult::create([
                "exam_id" => $exam->id,
                "user_id" => auth()->user()->id,
                "score" => 0,
                "total_right_answer" => 0,
                "start_time" => Carbon::now(),
                "end_time" => Carbon::now()->addMinutes($exam->time)
            ]);
        } else {
            if ($examResult->status)  // jika sudah mengikuti
                abort(403, 'Anda sudah mengikuti dan menyelesaikan ujian ini');
        }

        $exam->load(['subject', 'class', 'teacher']);
        $questions = $this->getQuestionWithStudentAnswered($exam);
        $student = Student::query()->where('user_id', '=', auth()->user()->id)->first();

        return view('exams.sheet', [
            "pretitle" => "Ujian",
            "title" => "Lembar Ujian",
            "exam" => $exam,
            'student' => $student,
            'questions' => $questions,
            "examResult" => $examResult
        ]);
    }

    public function saveOneQuestion(Request $request, Exam $exam)
    {
        $this->authorize('sheet', $exam);

        if ($this->isCannotTakeTheExam($exam)) // jika tidak boleh
            abort(403, 'Ujian belum dimulai atau ujian sudah berakhir');

        $idQuestion = $request->post('idQuestion');
        $option = $request->post('option');

        // cek apakah idQuestion dan user id sudah ada di student_answers
        // jika belum insert
        // jika sudah update
        $studentAnswer = StudentAnswer::updateOrCreate([
            "user_id" => auth()->user()->id,
            "exam_id" => $exam->id,
            "question_id" => $idQuestion
        ], [
            "answer" => $option
        ]);

        return ['success' => true, 'studentAnswer' => $studentAnswer];
    }

    public function saveExam(Request $request, Exam $exam)
    {
        $score = 0;
        $totalRightAnswer = 0;

        $questions = $this->getQuestionWithStudentAnswered($exam);
        foreach ($questions as $question) {
            if ($question->studentAnswer->answer === $question->right_option) { // jika benar
                $totalRightAnswer += 1;
            };
        };

        $score = ($totalRightAnswer / $questions->count())  * 100;

        ExamResult::query()->where([
            'exam_id' => $exam->id, 'user_id' => auth()->user()->id
        ])->first()->update([
            "score" => $score,
            "total_right_answer" => $totalRightAnswer,
            'status' => true
        ]);

        return redirect()->route('exams.index')->with('success', 'Anda sudah berhasil menyelesaikan ujian.');
    }

    /**
     * Untuk mengecek apakah tidak boleh mengikuti ujian 
     * atau
     * (belum waktu ujian dimulai atau waktu ujian sudah berakhir)
     * atau
     * (cek apakah ujian sedang berlangsung)
     */
    private function isCannotTakeTheExam($exam)
    {
        return strtotime($exam->start_date) > time() || strtotime($exam->end_date) < time();
    }

    private function getQuestionWithStudentAnswered(Exam $exam)
    {
        // ambil soal dengan mata pelajaran dan guru dari ujian saat ini dan juga dengan jawaban siswa dari yang saat ini sedang login
        return Question::query()
            ->where('teacher_id', '=', $exam->teacher->id)
            ->where('subject_id', '=', $exam->subject->id)
            ->where('exam_type_id', '=', $exam->exam_type_id)
            ->with(['studentAnswer' =>  function ($query) use ($exam) {
                $query->where([
                    'user_id' => auth()->user()->id,
                    'exam_id' => $exam->id,
                ]);
            }])
            ->limit($exam->total_question)
            ->get();
    }
}
