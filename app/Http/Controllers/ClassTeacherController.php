<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassTeacherRequests\ClassTeacherRequest;
use App\Models\Clazss;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\FlareClient\Http\Exceptions\NotFound;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ClassTeacherController extends Controller
{
    private string $table = 'class_teacher';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teachers = Teacher::query()->existsOnClassTeacher()->filter(request(['search', 'sort', 'direction']))
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
    public function store(ClassTeacherRequest $request)
    {
        $data = $this->getDataIds($request);
        DB::table($this->table)->insert($data);
        return redirect()
            ->route("relations.class-teacher.index")
            ->with('success', 'Data relasi kelas guru berhasil ditambahkan.');
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
        // data teachers doesn't exist on pivot table (data guru yang belum ada di class_teacher table)
        // orWhere berguna untuk get data guru yang saat ini digunakan agar bisa digunakan diview untuk function old()
        $avalaibleTeachers = Teacher::query()
            ->whereDoesntHave("classes")
            ->orWhere('id', $teacher->id)
            ->get();
        $allClasses = Clazss::query()->orderBy('name', 'asc')->get();
        $teacher = $teacher->load(['classes']); // class-teacher

        return view('relations.class-teacher.edit', [
            "pretitle" => "Relasi Kelas Guru",
            "title" => "Edit Data Relasi Kelas Guru",
            "teacher" => $teacher,
            "avalaibleTeachers" => $avalaibleTeachers,
            "allClasses" => $allClasses
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClassTeacherRequest $request, Teacher $teacher)
    {
        // hapus terlebih dahulu
        DB::transaction(function () use ($teacher, $request) {
            $data = $this->getDataIds($request);
            DB::table($this->table)->where('teacher_id', '=', $teacher->id)->delete();
            DB::table($this->table)->insert($data);
        }, 1);
        return redirect()->route("relations.class-teacher.index")->with('success', 'Data relasi kelas guru berhasil diubah.');
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
        return redirect()->route('relations.class-teacher.index')->with('success', 'Data relasi kelas guru berhasil dihapus.');
    }

    private function getDataIds($request): array
    {
        $teacher_id = $request->post('teacher_id');
        $data = [];
        foreach ($request->post('class_ids') as $id) {
            $data[] = [
                'class_id' => $id,
                'teacher_id'  => $teacher_id
            ];
        }
        return $data;
    }
}
