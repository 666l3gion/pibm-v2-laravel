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
                @include('partials.information-cards.class-teacher')
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