<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExamTypeRequests\ExamTypeRequest;
use App\Models\ExamType;
use Illuminate\Http\Request;

class ExamTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $examTypes = ExamType::query()->filter(request(['search', 'sort', 'direction']))
            ->paginate()
            ->withQueryString();

        return view('exam-types.index', [
            "pretitle" => "Jenis Ujian",
            "title" => "Data Jenis Ujian",
            "examTypes" => $examTypes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('exam-types.create', [
            "pretitle" => "Jenis Ujian",
            "title" => "Tambah Data Jenis Ujian"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExamTypeRequest $request)
    {
        ExamType::create($request->validated());
        return redirect()->route("exam-types.index")->with('success', 'Data jenis ujian berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ExamType $examType)
    {
        return view('exam-types.edit', [
            "pretitle" => "Jenis Ujian",
            "title" => "Edit Data Jenis Ujian",
            "examType" => $examType
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExamTypeRequest $request, ExamType $examType)
    {
        $examType->update($request->validated());
        return redirect()->route("exam-types.index")->with('success', 'Data jenis ujian berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExamType $examType)
    {
        $examType->delete();
        return redirect()->route('exam-types.index')->with('success', 'Data jenis jurusan berhasil dihapus.');
    }
}
