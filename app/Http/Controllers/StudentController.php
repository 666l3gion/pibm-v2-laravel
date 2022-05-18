<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequests\StoreStudentRequest;
use App\Http\Requests\StudentRequests\UpdateStudentRequest;
use App\Models\Student;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::query()->filter(request(['search', 'sort', 'direction']))
            ->paginate()
            ->withQueryString();

        return view('students.index', [
            "pretitle" => "Siswa",
            "title" => "Data Siswa",
            "students" => $students
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('students.create', [
            "pretitle" => "Siswa",
            "title" => "Tambah Data Siswa"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStudentRequest $request)
    {
        Student::create($request->validated());
        return redirect()->route("master.students.index")->with('success', 'Data siswa berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        return view('students.edit', [
            "pretitle" => "Siswa",
            "title" => "Edit Data Siswa",
            "student" => $student
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
        $student->update($request->validated());
        return redirect()->route("master.students.index")->with('success', 'Data siswa berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('master.students.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}
