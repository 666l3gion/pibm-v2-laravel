<?php

namespace App\Http\Controllers;

use App\Http\Requests\MajorSubjectRequests\MajorSubjectRequest;
use App\Models\Major;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MajorSubjectController extends Controller
{
    private string $table = 'major_subject';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = Subject::query()->existsOnMajorSubject()->filter(request(['search', 'sort', 'direction']))
            ->paginate()
            ->withQueryString();

        return view('relations.major-subject.index', [
            "pretitle" => "Relasi Mata Pelajaran Jurusan",
            "title" => "Data Relasi Mata Pelajaran Jurusan",
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
        // ambil data mapel yang belum ada di major_subject table
        $avalaibleSubjects = Subject::query()->whereDoesntHave("majors")->get();
        $majors = Major::query()->orderBy('name', 'asc')->get();

        return view('relations.major-subject.create', [
            "pretitle" => "Relasi Mata Pelajaran Jurusan",
            "title" => "Tambah Data Relasi Mata Pelajaran Jurusan",
            "avalaibleSubjects" => $avalaibleSubjects,
            "majors" => $majors
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MajorSubjectRequest $request)
    {
        $data = $this->getDataIds($request);
        DB::table($this->table)->insert($data);
        return redirect()
            ->route("relations.major-subject.index")
            ->with('success', 'Data relasi mata pelajaran jurusan berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject)
    {
        // using model route binding and orm
        // ambil data mapel yang belum ada di major_subject table
        // orWhere berguna untuk get data mapel yang saat ini digunakan agar bisa digunakan diview untuk function old()
        $avalaibleSubjects = Subject::query()
            ->whereDoesntHave("majors")
            ->orWhere('id', $subject->id)
            ->get();
        $allMajors = Major::query()->orderBy('name', 'asc')->get();
        $subject = $subject->load('majors'); // major-subject

        return view('relations.major-subject.edit', [
            "pretitle" => "Relasi Mata Pelajaran Jurusan",
            "title" => "Edit Data Relasi Mata Pelajaran Jurusan",
            "subject" => $subject,
            "avalaibleSubjects" => $avalaibleSubjects,
            "allMajors" => $allMajors
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MajorSubjectRequest $request, Subject $subject)
    {
        DB::transaction(function () use ($subject, $request) {
            $data = $this->getDataIds($request);
            // hapus terlebih dahulu
            DB::table($this->table)->where('subject_id', '=', $subject->id)->delete();
            DB::table($this->table)->insert($data);
        }, 1);
        return redirect()->route("relations.major-subject.index")->with('success', 'Data relasi mata pelajaran jurusan berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        DB::table($this->table)->where('subject_id', $subject->id)->delete();
        return redirect()->route('relations.subject-student.index')->with('success', 'Data relasi mata pelajaran jurusan berhasil dihapus.');
    }

    private function getDataIds($request): array
    {
        $subject_id = $request->post('subject_id');
        $data = [];
        foreach ($request->post('major_ids') as $id) {
            $data[] = [
                'subject_id'  => $subject_id,
                'major_id' => $id
            ];
        }
        return $data;
    }
}
