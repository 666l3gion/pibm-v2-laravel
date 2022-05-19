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
                @include('partials.information-cards.subject-teacher')
            </div>
            <div class="col-md-6">
                <form action="{{ route('relations.subject-teacher.store') }}" method="post" class="form-disable">
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

                                    <x-forms.select multiple="true" :required="true" name="subject_ids"
                                        label="Mata pelajaran" placeholder="Pilih mata pelajaran">
                                        @foreach ($subjects as $subject)
                                        @if( old('subject_id') == $subject->id)
                                        <option selected value="{{ $subject->id }}">{{ $subject->name }}</option>
                                        @else
                                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                        @endif
                                        @endforeach
                                    </x-forms.select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end align-items-center">
                            <div>
                                <a href="{{ route('relations.subject-teacher.index') }}" class="btn">Batal</a>
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