<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequests\StoreStudentRequest;
use App\Http\Requests\StudentRequests\UpdateStudentRequest;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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

    /**
     * Add data siswa to users
     */
    public function active(Student $student)
    {
        // is student already actived/registered
        $isActive = $student->user_id; // user_id or null

        if ($isActive) { // jika sudah aktif (maka hapus)
            User::find($student->user_id)->delete();
            $student->user_id = null;
            $student->save();
            return redirect()->route('master.students.index')->with('success', "Data siswa berhasil di hapus dari data user");
        }

        $user = User::create([
            "name" => $student->name,
            "role" => User::$SISWA_ROLE, // set role as guru/student
            "password" => Hash::make($student->nis),
            "email" => $student->email,
        ]);

        $student->user_id = $user->id;
        $student->save();
        return redirect()->route('master.students.index')->with('success', "Data siswa berhasil diaktifkan dengan email = '$student->email' dan password '$student->nis' (NIS).");
    }
}
