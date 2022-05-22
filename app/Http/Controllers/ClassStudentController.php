<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassStudentRequests\ClassStudentRequest;
use App\Models\Clazss;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassStudentController extends Controller
{
    private string $table = 'class_student';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = Clazss::query()->existsOnClassStudent()->filter(request(['search', 'sort', 'direction']))
            ->paginate()
            ->withQueryString();

        return view('relations.class-student.index', [
            "pretitle" => "Relasi Kelas Siswa",
            "title" => "Data Relasi Kelas Siswa",
            "classes" => $classes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // ambil data kelas yang belum ada di class_student table
        $avalaibleClasses = Clazss::query()->whereDoesntHave("students")->get();
        // ambil data siswa yang belum ada di class_student table
        $students = Student::query()->whereDoesntHave("classes")->orderBy('name', 'asc')->get();

        return view('relations.class-student.create', [
            "pretitle" => "Relasi Kelas Siswa",
            "title" => "Tambah Data Relasi Kelas Siswa",
            "avalaibleClasses" => $avalaibleClasses,
            "students" => $students
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClassStudentRequest $request)
    {
        $data = $this->getDataIds($request);
        DB::table($this->table)->insert($data);
        return redirect()
            ->route("relations.class-student.index")
            ->with('success', 'Data relasi kelas siswa berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Clazss $class)
    {
        // using model route binding and orm
        // data kelas yang belum ada di class_student table
        // orWhere berguna untuk get data kelas yang saat ini digunakan agar bisa digunakan diview untuk function old()
        $avalaibleClasses = Clazss::query()
            ->whereDoesntHave("students")
            ->orWhere('id', $class->id)
            ->get();
        $allStudents = Student::query()->orderBy('name', 'asc')->get();
        $class = $class->load(['students']); // class-student

        return view('relations.class-student.edit', [
            "pretitle" => "Relasi Kelas Siswa",
            "title" => "Edit Data Relasi Kelas Siswa",
            "class" => $class,
            "avalaibleClasses" => $avalaibleClasses,
            "allStudents" => $allStudents
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClassStudentRequest $request, Clazss $class)
    {
        DB::transaction(function () use ($class, $request) {
            $data = $this->getDataIds($request);
            // hapus terlebih dahulu
            DB::table($this->table)->where('class_id', '=', $class->id)->delete();
            DB::table($this->table)->insert($data);
        }, 1);
        return redirect()->route("relations.class-student.index")->with('success', 'Data relasi kelas siswa berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Clazss $class)
    {
        DB::table($this->table)->where('class_id', $class->id)->delete();
        return redirect()->route('relations.class-student.index')->with('success', 'Data relasi kelas siswa berhasil dihapus.');
    }

    private function getDataIds($request): array
    {
        $class_id = $request->post('class_id');
        $data = [];
        foreach ($request->post('student_ids') as $id) {
            $data[] = [
                'class_id'  => $class_id,
                'student_id' => $id
            ];
        }
        return $data;
    }
}
