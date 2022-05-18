@extends('layouts.app')

@section('content')
<div class="container-xl">
    <!-- Page title -->
    <div class="page-header d-print-none">
        <div class="row align-items-center mb-3">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    {{ $pretitle }}
                </div>
                <h2 class="page-title">
                    {{ $title }}
                </h2>
            </div>
        </div>

        <div class="row">
            <div class="col-md-5 mb-2">
                <div class="card card-stacked">
                    <div class="card">
                        <div class="ribbon ribbon-top bg-yellow">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <circle cx="12" cy="12" r="9" />
                                <line x1="12" y1="8" x2="12.01" y2="8" />
                                <polyline points="11 12 12 12 12 16 13 16" />
                            </svg>
                        </div>
                        <div class="card-body">
                            <h3 class="card-title">Informasi</h3>
                            <p>Jika kolom Guru kosong, berikut ini kemungkinan penyebabnya :</p>
                            <ol>
                                <li>
                                    Anda belum menambahkan master data Guru (Master Guru kosong/belum ada data sama
                                    sekali).
                                </li>
                                <li>
                                    Guru sudah ditambahkan, jadi anda tidak perlu tambah lagi. Anda hanya perlu mengedit
                                    data kelas Guru nya saja.
                                </li>
                                <li>
                                    Jika kelas yang anda ingin pilih tidak ada, pastikan anda sudah mencari dengan
                                    beberapa huruf awal dari kelas yang anda ingin pilih.
                                </li>
                                </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <form action="{{ route('relations.class-teacher.store') }}" method="post" class="form-disable">
                    @csrf

                    <div class="card mb-2">
                        <div class="card-header">
                            <h4 class="card-title">Form {{ $title }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <x-forms.select :required="true" name="teacher_id" label="Guru"
                                        placeholder="Pilih guru">
                                        @foreach ($avalaibleTeachers as $teacher)
                                        @if( old('teacher_id') == $teacher->id)
                                        <option selected value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                        @else
                                        <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                        @endif
                                        @endforeach
                                    </x-forms.select>

                                    <x-forms.select multiple="true" :required="true" name="class_ids"
                                        label="Kelas-kelas" placeholder="Pilih kelas-kelas">
                                        @foreach ($classes as $class)
                                        @if( old('class_id') == $class->id)
                                        <option selected value="{{ $class->id }}">{{ $class->name }}</option>
                                        @else
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                        @endif
                                        @endforeach
                                    </x-forms.select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end align-items-center">
                            <div>
                                <a href="{{ route('relations.class-teacher.index') }}" class="btn">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection