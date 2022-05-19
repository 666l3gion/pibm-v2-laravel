<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassRequests\ClassRequest;
use App\Models\Clazss;
use App\Models\Major;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = Clazss::query()->with('major')->filter(request(['search', 'sort', 'direction']))
            ->paginate()
            ->withQueryString();

        return view('classes.index', [
            "pretitle" => "Kelas",
            "title" => "Data Kelas",
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
        $majors = Major::all();
        return view('classes.create', [
            "pretitle" => "Kelas",
            "title" => "Tambah Data Kelas",
            "majors" => $majors
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClassRequest $request)
    {
        Clazss::create($request->validated());
        return redirect()->route("master.classes.index")->with('success', 'Data kelas berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Clazss $class)
    {
        $majors = Major::all();
        return view('classes.edit', [
            "pretitle" => "Kelas",
            "title" => "Edit Data Kelas",
            "class" => $class,
            "majors" => $majors
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClassRequest $request, Clazss $class)
    {
        $class->update($request->validated());
        return redirect()->route("master.classes.index")->with('success', 'Data kelas berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Clazss $class)
    {
        $class->delete();
        return redirect()->route('master.classes.index')->with('success', 'Data kelas berhasil dihapus.');
    }
}
