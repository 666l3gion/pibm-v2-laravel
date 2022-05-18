<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassTeacherRequests\StoreClassTeacherRequest;
use App\Models\Clazss;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassTeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teachers = Teacher::query()->with(['classes'])->filter(request(['search', 'sort', 'direction']))
            ->paginate()
            ->withQueryString();

        return view('relations.class-teacher.index', [
            "pretitle" => "Relasi Kelas Guru",
            "title" => "Data Relasi Kelas Guru",
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
        // data teachers doesn't exist on pivot table (data guru yang belum ada di class_teacher table)
        $avalaibleTeachers = Teacher::query()->whereDoesntHave("classes")->get();
        $classes = Clazss::query()->orderBy('name', 'asc')->get();

        return view('relations.class-teacher.create', [
            "pretitle" => "Relasi Kelas Guru",
            "title" => "Tambah Data Relasi Kelas Guru",
            "avalaibleTeachers" => $avalaibleTeachers,
            "classes" => $classes
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClassTeacherRequest $request)
    {
        $teacher_id = $request->validated()['teacher_id'];
        $data = [];
        foreach ($request->validated()['class_ids'] as $id) {
            $data[] = [
                'class_id' => $id,
                'teacher_id'  => $teacher_id
            ];
        }

        DB::table('class_teacher')->insert($data);

        return redirect()->route("relations.class-teacher.index")->with('success', 'Data relasi kelas guru berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher)
    {
        DB::table('class_teacher')->where('teacher_id', $teacher->id)->delete();
        return redirect()->route('relations.class-teacher.index')->with('success', 'Data relasi kelas guru berhasil dihapus.');
    }
}
