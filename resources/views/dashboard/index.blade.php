@extends('layouts.app')

@section('content')
<div class="container-xl">
    <!-- Page title -->
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    Overview
                </div>
                <h2 class="page-title">
                    Dashboard
                </h2>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="row row-deck row-cards mb-3">
            @if (auth()->user()->isSuperadminOrAdmin())
            <div class="row row-cards">
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h2 class="font-weight-bold">
                                        {{ $teacher_count }} Guru
                                    </h2>
                                    <a href="{{ route('master.teachers.index') }}" class="text-primary">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h2 class="font-weight-bold">
                                        {{ $student_count }} Siswa
                                    </h2>
                                    <a href="{{ route('master.students.index') }}" class="text-primary">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h2 class="font-weight-bold">
                                        {{ $class_count }} Kelas
                                    </h2>
                                    <a href="{{ route('master.classes.index') }}" class="text-primary">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h2 class="font-weight-bold">
                                        {{ $major_count }} Jurusan
                                    </h2>
                                    <a href="{{ route('master.majors.index') }}" class="text-primary">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h2 class="font-weight-bold">
                                        {{ $user_count }} Users
                                    </h2>
                                    <a href="{{ route('dashboard.users.index') }}" class="text-primary">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h2 class="font-weight-bold">
                                        {{ $question_count }} Soal
                                    </h2>
                                    <a href="{{ route('questions.index') }}" class="text-primary">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h2 class="font-weight-bold">
                                        {{ $exam_type_count }} Jenis Ujian
                                    </h2>
                                    <a href="{{ route('exam-types.index') }}" class="text-primary">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection