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
    </div>

    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header row">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <h3 class="card-title">{{ $title }}</h3>
                    </div>
                </div>

                <div class="card-body">
                    <div>
                        <h3>Soal</h3>
                        <div>
                            {!! $question->question !!}
                        </div>
                    </div>

                    <div class="mb-3">
                        <h3>Jawaban</h3>

                        @foreach (["a",'b','c','d','e'] as $option)
                        <div>
                            <h5>Pilihan {{ Str::upper($option) }} @if ($question->right_option === $option)
                                (Jawaban Benar)
                                @endif</h5>
                            <hr class="my-2">
                            <div>
                                {!! $question['option_' . $option] !!}
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div>
                        <ul>
                            <li>Dibuat pada {{ $question->created_at }}</li>
                            <li>Terakhir diubah {{ $question->updated_at }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection