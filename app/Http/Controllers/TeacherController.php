<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherRequests\StoreTeacherRequest;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teachers = Teacher::query()->filter(request(['search']));

        return view('teachers.index', [
            "pretitle" => "Guru",
            "title" => "Data Guru",
            "teachers" => $teachers->latest()->withQueryString()
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
        Teacher::create($request->all());
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
    public function update(Request $request, Teacher $teacher)
    {
        $rules = [
            'nip' => 'required|numeric|digits:18',
            'name' => 'required|max:255',
            'email' => 'required|email',
        ];

        if ($request->nip !== $teacher->nip)
            $rules['nip'] .= '|unique:teachers';

        $validatedData = $request->validate($rules);

        $teacher->update($validatedData);

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
