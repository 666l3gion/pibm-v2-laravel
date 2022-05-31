<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequests\QuestionRequest;
use App\Models\ExamType;
use App\Models\Question;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = [];
        if (auth()->user()->isSuperadminOrAdmin()) {
            $questions = Question::query()->with(['teacher', 'subject']);
        } else {
            $teacher = Teacher::query()->where('user_id', '=', auth()->user()->id)->first();
            $questions = Question::query()->where('teacher_id', '=', $teacher->id)->with(['teacher', 'subject']);
        }

        return view('questions.index', [
            "pretitle" => "Soal",
            "title" => "Data Soal",
            "questions" => $questions->filter(request(['search', 'sort', 'direction']))
                ->paginate()
                ->withQueryString()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Question::class);
        $teacher = Teacher::query()->where('user_id', '=', auth()->user()->id)->with('subjects')->first();
        $examTypes = ExamType::all();
        return view('questions.create', [
            "pretitle" => "Soal",
            "title" => "Tambah Data Soal",
            'teacher' => $teacher,
            "examTypes" => $examTypes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionRequest $request)
    {
        $this->authorize('create', Question::class);
        $validatedData = $request->validated();
        if ($request->file('image'))
            $validatedData['image'] = $request->file('image')->store('question-images');

        Question::create($validatedData);
        return redirect()->route("questions.index")->with('success', 'Data soal berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        return view('questions.show', [
            "pretitle" => "Soal",
            "title" => "Detail Data Soal",
            "question" => $question,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        $this->authorize('update', $question);
        $teacher = Teacher::query()->where('user_id', '=', auth()->user()->id)->with('subjects')->first();
        $examTypes = ExamType::all();

        return view('questions.edit', [
            "pretitle" => "Soal",
            "title" => "Edit Data Soal",
            "question" => $question,
            'teacher' => $teacher,
            "examTypes" => $examTypes
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuestionRequest $request, Question $question)
    {
        $this->authorize('update', $question);
        $validatedData = $request->validated();
        if ($request->file('image')) {
            if ($request->post('old-image')) Storage::delete($request->post('old-image'));
            $validatedData['image'] = $request->file('image')->store('question-images');
        }
        $question->update($validatedData);
        return redirect()->route("questions.index")->with('success', 'Data soal berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $this->authorize('delete', $question);
        $question->delete();
        return redirect()->route('questions.index')->with('success', 'Data soal berhasil dihapus.');
    }
}
