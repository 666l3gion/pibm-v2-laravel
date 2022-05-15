@extends('layouts.auth')

@section('content')
<div class="page page-center">
    <div class="container-tight py-4">
        <div class="text-center mb-4">
            <a href="" class="navbar-brand w-25">
                <img src="{{ asset('/images/logo.png') }}" alt="">
            </a>
        </div>
        <form class="card card-md" action="{{ route('login') }}" method="post" autocomplete="off">
            @csrf

            @if( session('failed') )
            <div class="alert alert-danger block" role="alert">
                {{ session('failed') }}
            </div>
            @endif

            @if( session('success') )
            <div class="alert alert-success block" role="alert">
                {{ session('success') }}
            </div>
            @endif

            <div class="card-body">
                <h2 class="card-title text-center mb-4">ELearning SMK Negeri 1 Stabat</h2>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="text" value="superadmin@gmail.com" autocapitalize="false" autofocus class="form-control @error('email') is-invalid is-invalid-lite @enderror" autocomplete="email" placeholder="Enter email" name="email">
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-2">
                    <label class="form-label">
                        Password
                    </label>
                    <div>
                        <input type="password" class="form-control @error('password') is-invalid is-invalid-lite @enderror" value="123" placeholder="Password" autocomplete="off" name="password" id="password">
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-2">
                    <label class="form-check">
                        <input type="checkbox" class="form-check-input" name="remember" />
                        <span class="form-check-label">Remember me on this device</span>
                    </label>
                </div>
                <div class="form-footer">
                    <button type="submit" class="btn btn-primary w-100">Masuk</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection