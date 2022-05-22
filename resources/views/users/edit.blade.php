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
                <form action="{{ route('dashboard.users.update', ['user' => $user->id]) }}" method="post"
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
                                    <x-forms.input :required="true" name="name" label="Nama User"
                                        old="{{ old('name', $user->name) }}" />
                                    <x-forms.input :required="true" name="email" label="Email User"
                                        old="{{ old('email', $user->email) }}" />

                                    @if (!$user->isSuperadmin() && !$user->ownByLoggedInUser()) {{-- jika
                                    akun yang diedit bukan akun
                                    milik yang ssat ini login --}}
                                    <x-forms.select :required="true" name="role" label="Level User"
                                        placeholder="Pilih level user">
                                        @foreach ($user->avalaibleRoles() as $role)
                                        @if( old('role', $user->role) == $role)
                                        <option selected value="{{ $role }}">{{ $role }}</option>
                                        @else
                                        <option value="{{ $role }}">{{ $role }}</option>
                                        @endif
                                        @endforeach
                                    </x-forms.select>
                                    <div>
                                        <div class="form-label">Status</div>
                                        <div>
                                            <label class="form-check">
                                                <input class="form-check-input" type="radio" value="1" name="is_active"
                                                    @if($user->is_active)
                                                checked
                                                @endif
                                                />
                                                <span class="form-check-label">Aktif</span>
                                            </label>
                                            <label class="form-check">
                                                <input class="form-check-input" value="0" type="radio" name="is_active"
                                                    @if(!$user->is_active)
                                                checked
                                                @endif />
                                                <span class="form-check-label">Tidak Aktif</span>
                                            </label>
                                        </div>
                                        @error('is_active')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end align-items-center">
                            <div>
                                <a href="{{ route('dashboard.users.index') }}" class="btn">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <form action="{{ route('auth.change-password') }}" method="post"
                    onsubmit="return (confirm('Apakah anda yakin ingin mengubah password ini?') && showLoading(this) )">
                    @csrf
                    @method('PUT')

                    <div class="card mb-2">
                        <div class="card-header">
                            <h4 class="card-title">Form Ubah Password</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <x-forms.input type="password" :required="true" name="current_password"
                                        label="Password Saat Ini" />
                                    <x-forms.input type="password" :required="true" name="new_password"
                                        label="Password Baru" />
                                    <x-forms.input type="password" :required="true" name="new_password_confirmation"
                                        label="Konfirmasi Password Baru" placeholder="Masukan password baru" />
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end align-items-center">
                            <div>
                                <a href="{{ route('dashboard.users.index') }}" class="btn">Batal</a>
                                <button type="submit" class="btn btn-warning">Ganti Password</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection