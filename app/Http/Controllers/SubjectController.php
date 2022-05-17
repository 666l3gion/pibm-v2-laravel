<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubjectRequests\SubjectRequest;
use App\Models\Subject;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = Subject::query()->filter(request(['search', 'sort', 'direction']))
            ->paginate()
            ->withQueryString();

        return view('subjects.index', [
            "pretitle" => "Mata Pelajaran",
            "title" => "Data Mata Pelajaran",
            "subjects" => $subjects
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('subjects.create', [
            "pretitle" => "Mata Pelajaran",
            "title" => "Tambah Data Mata Pelajaran"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubjectRequest $request)
    {
        Subject::create($request->validated());
        return redirect()->route("master.subjects.index")->with('success', 'Data mata pelajaran berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject)
    {
        return view('subjects.edit', [
            "pretitle" => "Mata Pelajaran",
            "title" => "Edit Data Mata Pelajaran",
            "subject" => $subject
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(SubjectRequest $request, Subject $subject)
    {
        $subject->update($request->validated());
        return redirect()->route("master.subjects.index")->with('success', 'Data mata pelajaran berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->route('master.subjects.index')->with('success', 'Data mata pelajaran berhasil dihapus.');
    }
}
