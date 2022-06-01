@extends('layouts.app')

@section('content')
<div class="container-xl">
    <!-- Page title -->
    <div class="page-header d-print-none">
        <div class="row align-items-center mb-3 text-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    {{ $pretitle }}
                </div>
                <h2 class="page-title justify-content-center">
                    {{ $title }}
                </h2>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-header row">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <h3 class="card-title">{{ $title }}</h3>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="py-2 mb-4 text-center">
                                <small class="text-muted d-block mb-3 text-uppercase">Nilai</small>
                                @if ($examResult->score >= 80)
                                <h1 class="fw-bold d-block mx-auto bg-success text-white px-3 rounded-3"
                                    style="font-size: 4rem !important; max-width: fit-content;">
                                    {{ $examResult->score }}
                                </h1>
                                <small class="d-block mt-2 text-success">Bagus</small>
                                @elseif($examResult->score > 65)
                                <h1 class="fw-bold d-block mx-auto bg-warning text-white px-3 rounded-3"
                                    style="font-size: 4rem !important; max-width: fit-content;">
                                    {{ $examResult->score }}
                                </h1>
                                <small class="d-block mt-2 text-warning">Cukup</small>
                                @else
                                <h1 class="fw-bold d-block mx-auto bg-danger text-white px-3 rounded-3"
                                    style="font-size: 4rem !important; max-width: fit-content;">
                                    {{ $examResult->score }}
                                </h1>
                                <small class="d-block mt-2 text-danger">Buruk</small>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="py-2">
                                        <span class="fw-bold d-block text-muted">Nama</span>
                                        {{ $student->name }}
                                    </div>
                                    <div class="py-2">
                                        <span class="fw-bold d-block text-muted">Guru</span>
                                        {{ $exam->teacher->name }}
                                    </div>
                                    <div class="py-2">
                                        <span class="fw-bold d-block text-muted">Kelas/Jurusan</span>
                                        {{ $exam->class->name }}/{{
                                        $exam->class->major->name }}
                                    </div>
                                    <div class="py-2">
                                        <span class="fw-bold d-block text-muted">Nama Ujian</span>
                                        {{ $exam->name }}
                                    </div>
                                    <div class="py-2">
                                        <span class="fw-bold d-block text-muted">Jumlah Soal</span>
                                        {{ $exam->total_question }}
                                    </div>
                                    <div class="py-2">
                                        <span class="fw-bold d-block text-muted">Jumlah Benar</span>
                                        {{ $examResult->total_right_answer }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="py-2">
                                        <span class="fw-bold d-block text-muted">Tanggal Mulai Ujian</span>
                                        {{ $exam->start_date }}
                                    </div>
                                    <div class="py-2">
                                        <span class="fw-bold d-block text-muted">Tanggal Berakhir Ujian</span>
                                        {{ $exam->end_date }}
                                    </div>
                                    <div class="py-2">
                                        <span class="fw-bold d-block text-muted">Waktu Mulai Siswa Mengikuti
                                            Ujian</span>
                                        {{ $examResult->start_time }}
                                    </div>
                                    <div class="py-2">
                                        <span class="fw-bold d-block text-muted">Waktu Berakhir Siswa Mengikuti
                                            Ujian</span>
                                        {{ $examResult->end_time }}
                                    </div>
                                    <div class="py-2">
                                        <span class="fw-bold d-block text-muted">Waktu</span>
                                        {{ $exam->time }} Menit
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection