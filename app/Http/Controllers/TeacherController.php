<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherRequests\StoreTeacherRequest;
use App\Http\Requests\TeacherRequests\UpdateTeacherRequest;
use App\Models\Teacher;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teachers = Teacher::query()->filter(request(['search', 'sort', 'direction']))
            ->paginate()
            ->withQueryString();

        return view('teachers.index', [
            "pretitle" => "Guru",
            "title" => "Data Guru",
            "teachers" => $teachers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('teachers.create', [
            "pretitle" => "Guru",
            "title" => "Tambah Data Guru"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTeacherRequest $request)
    {
        Teacher::create($request->validated());
        return redirect()->route("master.teachers.index")->with('success', 'Data guru berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Teacher $teacher)
    {
        return view('teachers.edit', [
            "pretitle" => "Guru",
            "title" => "Edit Data Guru",
            "teacher" => $teacher
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTeacherRequest $request, Teacher $teacher)
    {
        $teacher->update($request->validated());
        return redirect()->route("master.teachers.index")->with('success', 'Data guru berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher)
    {
        // TODO: handle onDelete
        $teacher->delete();
        return redirect()->route('master.teachers.index')->with('success', 'Data guru berhasil dihapus.');
    }
}
