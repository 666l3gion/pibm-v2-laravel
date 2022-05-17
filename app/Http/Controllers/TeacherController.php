<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherRequests\StoreTeacherRequest;
use App\Http\Requests\TeacherRequests\UpdateTeacherRequest;
use App\Models\Role;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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

    /**
     * Add data teacher to users
     */
    public function active(Teacher $teacher)
    {
        // is teacher already actived/registered
        $isActive = $teacher->user_id; // user_id or null

        if ($isActive) { // jika sudah aktif (maka hapus)
            User::find($teacher->user_id)->delete();
            $teacher->user_id = null;
            $teacher->save();
            return redirect()->route('master.teachers.index')->with('success', "Data guru berhasil di hapus dari data user");
        }

        $user = User::create([
            "name" => $teacher->name,
            "role" => User::$GURU_ROLE, // set role as guru/teacher
            "password" => Hash::make($teacher->nip),
            "email" => $teacher->email,
        ]);
        $teacher->user_id = $user->id;
        $teacher->save();
        return redirect()->route('master.teachers.index')->with('success', "Data guru berhasil diaktifkan dengan email = '$teacher->email' dan password '$teacher->nip' (NIP).");
    }
}
