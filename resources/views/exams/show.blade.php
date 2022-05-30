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
                    {{ $title }} / Konfirmasi Data
                </h2>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header row">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <h3 class="card-title">{{ $title }}</h3>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="py-2">
                                <span class="fw-bold d-block">Nama</span>
                                {{ $student->name }}
                            </div>
                            <div class="py-2">
                                <span class="fw-bold d-block">Guru</span>
                                {{ $exam->teacher->name }}
                            </div>
                            <div class="py-2">
                                <span class="fw-bold d-block">Kelas/Jurusan</span>
                                {{ $exam->class->name }}/{{
                                $exam->class->major->name }}
                            </div>
                            <div class="py-2">
                                <span class="fw-bold d-block">Nama Ujian</span>
                                {{ $exam->name }}
                            </div>
                            <div class="py-2">
                                <span class="fw-bold d-block">Jumlah Soal</span>
                                {{ $exam->total_question }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="py-2">
                                <span class="fw-bold d-block">Tanggal Mulai</span>
                                {{ $exam->start_date }}
                            </div>
                            <div class="py-2">
                                <span class="fw-bold d-block">Tanggal Berakhir</span>
                                {{ $exam->end_date }}
                            </div>
                            <div class="py-2">
                                <span class="fw-bold d-block">Waktu</span>
                                {{ $exam->time }} Menit
                            </div>

                            <x-forms.input :disabled="true" required="true" name="token" label="Token"
                                old="{{ old('token', $exam->token) }}" />

                            <div>
                                @if (strtotime($exam->start_date) > time())
                                <p>Ujian akan dimulai pada {{ $exam->start_date }}.</p>
                                @elseif (strtotime($exam->end_date) > time())
                                <a href="" class="btn btn-primary">Masuk</a>
                                @else
                                <p class="text-danger">Anda terlambat untuk mengikuti ujian.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection