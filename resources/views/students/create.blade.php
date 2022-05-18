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
                <form action="{{ route('master.students.store') }}" method="post" class="form-disable">
                    @csrf

                    <div class="card mb-2">
                        <div class="card-header">
                            <h4 class="card-title">Form {{ $title }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <x-forms.input :required="true" name="nis" label="NIS" old="{{ old('nis') }}" />
                                    <x-forms.input :required="true" name="name" label="Nama Siswa"
                                        old="{{ old('name') }}" />
                                    <x-forms.input :required="true" name="email" label="Email Siswa"
                                        old="{{ old('email') }}" />
                                    <x-forms.select :required="true" name="gender" label="Jenis Kelamin"
                                        placeholder="Pilih jenis kelamin">
                                        <option @if( old('gender')==="L" ) selected @endif value="L">Laki-laki
                                        </option>
                                        <option @if( old('gender')==="P" ) selected @endif value="P">Perempuan</option>
                                    </x-forms.select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end align-items-center">
                            <div>
                                <a href="{{ route('master.students.index') }}" class="btn btn-light">Batal</a>
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