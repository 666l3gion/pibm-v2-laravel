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
                @include('partials.information-cards.class-student')
            </div>
            <div class="col-md-6">
                <form action="{{ route('relations.class-student.update', ['class_student' => $class->id]) }}"
                    method="post" class="form-disable">
                    @csrf
                    @method('PUT')

                    <div class="card mb-2">
                        <div class="card-header">
                            <h4 class="card-title">Form {{ $title }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <x-forms.select :required="true" name="class_id" label="Kelas"
                                        placeholder="Pilih kelas">
                                        @foreach ($avalaibleClasses as $avalaibleTeacher)
                                        @if( old('class_id', $class->id) == $avalaibleTeacher->id)
                                        <option selected value="{{ $avalaibleTeacher->id }}">{{ $avalaibleTeacher->name
                                            }}</option>
                                        @else
                                        <option value="{{ $avalaibleTeacher->id }}">{{ $avalaibleTeacher->name }}
                                        </option>
                                        @endif
                                        @endforeach
                                    </x-forms.select>

                                    <x-forms.select multiple="true" :required="true" name="student_ids"
                                        label="Siswa-siswa" placeholder="Pilih siswa-siswa">
                                        @foreach ($allStudents as $student)
                                        @foreach ($class->students as $st) {{-- untuk function old() dibawah agar
                                        otomatis menselected multiple --}}
                                        @if( old('student_id', $st->id) == $student->id)
                                        <option selected value="{{ $student->id }}">{{ $student->name }}</option>
                                        @endif
                                        @endforeach
                                        <option value="{{ $student->id }}">{{ $student->name }}</option>
                                        @endforeach
                                    </x-forms.select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end align-items-center">
                            <div>
                                <a href="{{ route('relations.class-student.index') }}" class="btn">Batal</a>
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