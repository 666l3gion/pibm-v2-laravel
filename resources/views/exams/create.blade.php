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
            <div class="col-md-9">
                <form action="{{ route('exams.store') }}" method="post" class="form-disable">
                    @csrf

                    <div class="card mb-2">
                        <div class="card-header">
                            <h4 class="card-title">Form {{ $title }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">

                                    <x-forms.select :required="true" name="subject_id" label="Mata Pelajaran"
                                        placeholder="Pilih mata pelajaran">
                                        @foreach ($teacher->subjects as $subject)
                                        @if( old('subject_id') == $subject->id)
                                        <option selected value="{{ $subject->id }}">{{
                                            $subject->name }}</option>
                                        @else
                                        <option value="{{ $subject->id }}">{{ $subject->name }}
                                        </option>
                                        @endif
                                        @endforeach
                                    </x-forms.select>

                                    <x-forms.select :required="true" name="class_id" label="Kelas"
                                        placeholder="Pilih kelas">
                                        @foreach ($teacher->classes as $class)
                                        @if( old('class_id') == $class->id)
                                        <option selected value="{{ $class->id }}">{{
                                            $class->name }}</option>
                                        @else
                                        <option value="{{ $class->id }}">{{ $class->name }}
                                        </option>
                                        @endif
                                        @endforeach
                                    </x-forms.select>

                                    <div>
                                        <h3>Guru</h3>
                                        <p>{{ $teacher->name }}</p>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <x-forms.input :required="true" name="name" label="Nama Ujian"
                                        old="{{ old('name') }}" />

                                    <x-forms.input :required="true" type="number" name="total_question"
                                        label="Jumlah Soal" old="{{ old('total_question') }}" />

                                    <x-forms.input :required="true" type="datetime-local" name="start_date"
                                        label="Tanggal Mulai" old="{{ old('start_date') }}" />

                                    <x-forms.input :required="true" type="datetime-local" name="end_date"
                                        label="Tanggal Berakhir" old="{{ old('end_date') }}" />

                                    <x-forms.input :required="true" type="number" name="time" label="Waktu (Menit)"
                                        old="{{ old('time') }}" />

                                    <x-forms.select :required="true" name="exam_type_id" label="Jenis Ujian"
                                        placeholder="Pilih jenis ujian">
                                        @foreach ($examTypes as $examType)
                                        @if( old('exam_type_id') == $examType->id)
                                        <option selected value="{{ $examType->id }}">{{ $examType->name }}</option>
                                        @else
                                        <option value="{{ $examType->id }}">{{ $examType->name }}</option>
                                        @endif
                                        @endforeach
                                    </x-forms.select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end align-items-center">
                            <div class="mb-2">
                                <a href="{{ route('exams.index') }}" class="btn">Batal</a>
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