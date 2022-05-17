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
            <div class="col-md-6">
                <form action="{{ route('master.classes.update', ['class' => $class->id]) }}" method="post"
                    class="form-disable">
                    @csrf
                    @method('PUT')

                    <div class="card mb-2">
                        <div class="card-header">
                            <h4 class="card-title">Form {{ $title }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <x-forms.input :required="true" name="name" label="Nama Kelas"
                                        old="{{ old('name', $class->name) }}" />
                                    <x-forms.select :required="true" name="major_id" label="Jurusan"
                                        placeholder="Pilih jurusan">
                                        @foreach ($majors as $major)
                                        @if( old('major_id', $class->major_id) == $major->id)
                                        <option selected value="{{ $major->id }}">{{ $major->name }}</option>
                                        @else
                                        <option value="{{ $major->id }}">{{ $major->name }}</option>
                                        @endif
                                        @endforeach
                                    </x-forms.select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end align-items-center">
                            <div>
                                <a href="{{ route('master.classes.index') }}" class="btn btn-light">Batal</a>
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