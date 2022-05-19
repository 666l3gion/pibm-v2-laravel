<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubjectTeacherRequests\SubjectTeacherRequest;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubjectTeacherController extends Controller
{
    private string $table = 'subject_teacher';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teachers = Teacher::query()->existsOnSubjectTeacher()->filter(request(['search', 'sort', 'direction']))
            ->paginate()
            ->withQueryString();

        return view('relations.subject-teacher.index', [
            "pretitle" => "Relasi Guru Mata Pelajaran",
            "title" => "Data Relasi Guru Mata Pelajaran",
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
        // ambil data guru yang belum ada di subject_teacher table
        $avalaibleTeachers = Teacher::query()->whereDoesntHave("subjects")->get();
        $subjects = Subject::query()->orderBy('name', 'asc')->get();

        return view('relations.subject-teacher.create', [
            "pretitle" => "Relasi Guru Mata Pelajaran",
            "title" => "Tambah Data Relasi Guru Mata Pelajaran",
            "avalaibleTeachers" => $avalaibleTeachers,
            "subjects" => $subjects
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubjectTeacherRequest $request)
    {
        $data = $this->getDataIds($request);
        DB::table($this->table)->insert($data);
        return redirect()
            ->route("relations.subject-teacher.index")
            ->with('success', 'Data relasi guru mata pelajaran berhasil ditambahkan.');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Teacher $teacher)
    {
        // using model route binding and orm
        // ambil data guru yang belum ada di subject_teacher table
        // orWhere berguna untuk get data guru yang saat ini digunakan agar bisa digunakan diview untuk function old()
        $avalaibleTeachers = Teacher::query()
            ->whereDoesntHave("subjects")
            ->orWhere('id', $teacher->id)
            ->get();
        $allSubjects = Subject::query()->orderBy('name', 'asc')->get();
        $teacher = $teacher->load('subjects'); // subject_teacher

        return view('relations.subject-teacher.edit', [
            "pretitle" => "Relasi Guru Mata Pelajaran",
            "title" => "Edit Data Relasi Guru Mata Pelajaran",
            "teacher" => $teacher,
            "avalaibleTeachers" => $avalaibleTeachers,
            "allSubjects" => $allSubjects
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SubjectTeacherRequest $request, Teacher $teacher)
    {
        DB::transaction(function () use ($teacher, $request) {
            $data = $this->getDataIds($request);
            // hapus terlebih dahulu
            DB::table($this->table)->where('teacher_id', '=', $teacher->id)->delete();
            DB::table($this->table)->insert($data);
        }, 1);
        return redirect()->route("relations.subject-teacher.index")->with('success', 'Data relasi guru mata pelajaran berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher)
    {
        DB::table($this->table)->where('teacher_id', $teacher->id)->delete();
        return redirect()->route('relations.subject-teacher.index')->with('success', 'Data relasi guru mata pelajaran berhasil dihapus.');
    }

    private function getDataIds($request): array
    {
        $teacher_id = $request->post('teacher_id');
        $data = [];
        foreach ($request->post('subject_ids') as $id) {
            $data[] = [
                'teacher_id'  => $teacher_id,
                'subject_id' => $id
            ];
        }
        return $data;
    }
}
