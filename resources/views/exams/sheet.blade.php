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
        <div class="col-md-4 mb-2">
            <div class="card mb-2">
                <div class="card-header row">
                    <div class="col-md-6">
                        <h3 class="card-title">Informasi Ujian</h3>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="py-2">
                                <span class="fw-bold d-block">Nama Ujian</span>
                                {{ $exam->name }}
                            </div>
                            <div class="py-2">
                                <span class="fw-bold d-block">Jumlah Soal</span>
                                {{ $exam->total_question }}
                            </div>
                            <div class="py-2">
                                <span class="fw-bold d-block">Sisa Waktu</span>
                                <span class="badge bg-success">43 Menit Lagi</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="col-md-6">
                        <h3 class="card-title">Daftar Soal</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row gx-2 gy-2" id="question-nav-menu">
                        @foreach ($questions as $question)
                        <div class="col-2">
                            <a href="#question-{{ $question->id }}" class="btn btn-light w-100">#{{ $loop->iteration
                                }}</a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card mt-2 mt-md-0 mb-2">
                <div class="card-body">
                    <button id="toggle-collapse-accordion-question"
                        class="btn btn-info d-flex align-items-center justify-content-center" data-open="1">
                        Tutup Semua Soal
                    </button>
                </div>
            </div>

            <form action="{{ route('exams.save-exam', $exam->id) }}" method="post"
                onsubmit="return confirm('Apakah anda yakin ingin mengakhiri ujian ini?')" data-bs-spy="scroll"
                data-bs-target="#question-nav-menu" data-bs-offset="0" tabindex="0">
                @csrf
                @foreach ($questions as $question)
                <div class="card mb-2" id="question-{{ $question->id }}">
                    <div class="accordion" id="accordion-question-{{ $question->id }}">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading-question-{{ $question->id }}">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse-question-{{ $question->id }}" aria-expanded="true">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="fw-bold d-inline-block badge bg-success me-2">Soal #{{
                                            $loop->iteration
                                            }}</small>
                                        <small
                                            class="fw-bold badge bg-light text-muted d-none saved_status_question_{{ $question->id }}"></small>
                                    </div>
                                </button>
                            </h2>
                            <div id="collapse-question-{{ $question->id }}" class=" accordion-collapse collapse
                                    show" data-bs-parent="#accordion-question-{{ $question->id }}">
                                <div class="card-body">
                                    <div class="accordion-body pt-0 p-0">
                                        @if ($question->image)
                                        <a href="{{ asset('storage/' . $question->image) }}" class="d-block"
                                            target="_blank">
                                            <img src="{{ asset('storage/' . $question->image) }}"
                                                alt="Question no.{{ $loop->iteration }} image"
                                                class="img-thumbnail w-25">
                                        </a>
                                        @endif
                                        <p>{!! $question->question !!}</p>
                                        <div>
                                            @foreach (['a','b','c','d','e'] as $option)
                                            <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column"
                                                style="margin-bottom: .1px !important;">
                                                <label class="form-selectgroup-item flex-fill">
                                                    @if ($question->studentAnswer &&
                                                    $question->studentAnswer->question_id ===
                                                    $question->id && $question->studentAnswer->answer === $option)
                                                    <input type="radio" name="question_{{ $question->id }}[]"
                                                        id="question_{{ $option }}_{{ $question->id }}" checked
                                                        data-id-question="{{ $question->id }}"
                                                        data-option="{{ $option }}"
                                                        class="form-selectgroup-input question-options">
                                                    @else
                                                    <input type="radio" name="question_{{ $question->id }}[]"
                                                        id="question_{{ $option }}_{{ $question->id }}"
                                                        data-id-question="{{ $question->id }}"
                                                        data-option="{{ $option }}"
                                                        class="form-selectgroup-input question-options">
                                                    @endif

                                                    <div class="form-selectgroup-label d-flex align-items-center p-3">
                                                        <div class="me-3">
                                                            {{-- <span class="form-selectgroup-check"></span> --}}
                                                            <span class="text-uppercase fw-bold">{{ $option }}.</span>
                                                        </div>
                                                        <div class="reset-p-margin">
                                                            {!! $question['option_' . $option]; !!}
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="card">
                    <div class="card-footer">
                        <button class="btn btn-primary w-100">Selesai</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<button class="btn btn-primary d-none" id="back-to-top">
    <!-- Download SVG icon from http://tabler-icons.io/i/chevron-up -->
    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="3"
        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
        <polyline points="6 15 12 9 18 15" />
    </svg>
</button>
@endsection

@push('scripts')
<script>
    const saveOneQuestionApiEndpoint = "{{ route('exams.save-one-question', $exam->id) }}";
</script>
<script src="{{ asset('js/sheet.js') }}"></script>
@endpush

{{--
<div class="row">
    <div class="col">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <small class="fw-bold d-inline-block badge bg-success">Soal #{{
                $loop->iteration
                }}</small>
            <small class="fw-bold badge bg-light text-muted d-none saved_status_question_{{ $question->id }}"></small>
        </div>
        @if ($question->image)
        <a href="{{ asset('storage/' . $question->image) }}" class="d-block" target="_blank">
            <img src="{{ asset('storage/' . $question->image) }}" alt="Question no.{{ $loop->iteration }} image"
                class="img-thumbnail w-25">
        </a>
        @endif
        <p>{!! $question->question !!}</p>
        <div>
            @foreach (['a','b','c','d','e'] as $option)
            <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column"
                style="margin-bottom: .1px !important;">
                <label class="form-selectgroup-item flex-fill">
                    @if ($question->studentAnswer && $question->studentAnswer->question_id ===
                    $question->id && $question->studentAnswer->answer === $option)
                    <input type="radio" name="question_{{ $question->id }}[]"
                        id="question_{{ $option }}_{{ $question->id }}" checked data-id-question="{{ $question->id }}"
                        data-option="{{ $option }}" class="form-selectgroup-input question-options">
                    @else
                    <input type="radio" name="question_{{ $question->id }}[]"
                        id="question_{{ $option }}_{{ $question->id }}" data-id-question="{{ $question->id }}"
                        data-option="{{ $option }}" class="form-selectgroup-input question-options">
                    @endif

                    <div class="form-selectgroup-label d-flex align-items-center p-3">
                        <div class="me-3">
                            {{-- <span class="form-selectgroup-check"></span> --}}
                            {{--
                            <span class="text-uppercase fw-bold">{{ $option }}.</span>
                        </div>
                        <div class="reset-p-margin">
                            {!! $question['option_' . $option]; !!}
                        </div>
                    </div>
                </label>
            </div>
            @endforeach
        </div>
    </div>
</div>
--}}