<?php

namespace App\Http\Controllers;

use App\Http\Requests\MajorRequests\MajorRequest;
use App\Models\Major;
use Illuminate\Http\Request;

class MajorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $majors = Major::query()->filter(request(['search', 'sort', 'direction']))
            ->paginate()
            ->withQueryString();

        return view('majors.index', [
            "pretitle" => "Jurusan",
            "title" => "Data Jurusan",
            "majors" => $majors
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('majors.create', [
            "pretitle" => "Jurusan",
            "title" => "Tambah Data Jurusan"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MajorRequest $request)
    {
        Major::create($request->validated());
        return redirect()->route("master.majors.index")->with('success', 'Data jurusan berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Major $major)
    {
        return view('majors.edit', [
            "pretitle" => "Jurusan",
            "title" => "Edit Data Jurusan",
            "major" => $major
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MajorRequest $request, Major $major)
    {
        $major->update($request->validated());
        return redirect()->route("master.majors.index")->with('success', 'Data jurusan berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Major $major)
    {
        // TODO: handle onDelete seteleh sampai crud class
        $major->delete();
        return redirect()->route('master.majors.index')->with('success', 'Data jurusan berhasil dihapus.');
    }
}
