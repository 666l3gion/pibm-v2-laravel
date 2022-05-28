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
            <div class="col-md-10">
                <form action="{{ route('questions.update', ['question' => $question->id]) }}" method="post"
                    class="form-disable" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card mb-2">
                        <div class="card-header">
                            <h4 class="card-title">Form {{ $title }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">

                                    <x-forms.select :required="true" name="subject_id" label="Guru (Mata Pelajaran)"
                                        placeholder="Pilih guru (mata pelajaran)">
                                        @foreach ($teacher->subjects as $subject)
                                        @if( old('subject_id', $question->subject_id) == $subject->id)
                                        <option selected value="{{ $subject->id }}">{{ $teacher->name }} ~ {{
                                            $subject->name }}</option>
                                        @else
                                        <option value="{{ $subject->id }}">{{ $teacher->name }} ~ {{ $subject->name }}
                                        </option>
                                        @endif
                                        @endforeach
                                    </x-forms.select>

                                    <div class="mb-2">
                                        <label class="form-label required">Soal</label>
                                        <div class="mb-1">
                                            @if ($question->image)
                                            <img src="{{ asset('storage/' . $question->image) }}" alt="Question's Image"
                                                class="mb-2">
                                            <input type="hidden" name="old-image" value="{{ $question->image }}">
                                            @endif

                                            <input type="file" class="form-control" name="image" id="image" />

                                            @error("image")
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div id="question-editor" class="w-100" style="height: 150px;">{!!
                                            old('question', $question->question) !!}</div>
                                        <input type="hidden" name="question" id="question"
                                            value="{{ old('question', $question->question) }}" />
                                        @error("question")
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="mb-2">
                                        <label class="form-label required">Jawaban A</label>
                                        <div id="option-a-editor" class="w-100">{!! old("option_a", $question->option_a)
                                            !!}</div>
                                        <input type="hidden" name="option_a" id="option_a" value="{{ old('option_a', $question->option_a)
                                            }}" />
                                        @error("option_a")
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="mb-2">
                                        <label class="form-label required">Jawaban B</label>
                                        <div id="option-b-editor" class="w-100">{!! old("option_b", $question->option_b)
                                            !!}</div>
                                        <input type="hidden" name="option_b" id="option_b" value="{{ old('option_b', $question->option_b)
                                            }}" />
                                        @error("option_b")
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="mb-2">
                                        <label class="form-label required">Jawaban C</label>
                                        <div id="option-c-editor" class="w-100">{!! old("option_c", $question->option_c)
                                            !!}</div>
                                        <input type="hidden" name="option_c" id="option_c" value="{{ old('option_c', $question->option_c)
                                            }}" />
                                        @error("option_c")
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="mb-2">
                                        <label class="form-label required">Jawaban D</label>
                                        <div id="option-d-editor" class="w-100">{!! old("option_d", $question->option_d)
                                            !!}</div>
                                        <input type="hidden" name="option_d" id="option_d" value="{{ old('option_d', $question->option_d)
                                            }}" />
                                        @error("option_d")
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="mb-2">
                                        <label class="form-label required">Jawaban E</label>
                                        <div id="option-e-editor" class="w-100">{!! old("option_e", $question->option_e)
                                            !!}</div>
                                        <input type="hidden" name="option_e" id="option_e" value="{{ old('option_e', $question->option_e)
                                            }}" />
                                        @error("option_e")
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <x-forms.select :required="true" name="right_option" label="Jawaban Benar"
                                        placeholder="Pilih jawaban benar">
                                        @foreach (['a','b','c','d','e'] as $option)
                                        @if( old('right_option', $question->right_option) == $option)
                                        <option selected value="{{ $option }}">{{ Str::upper($option) }}</option>
                                        @else
                                        <option value="{{ $option }}">{{ Str::upper($option) }}</option>
                                        @endif
                                        @endforeach
                                    </x-forms.select>

                                    <x-forms.select :required="true" name="exam_type_id" label="Jenis Ujian"
                                        placeholder="Pilih jenis ujian">
                                        @foreach ($examTypes as $examType)
                                        @if( old('exam_type_id', $question->exam_type_id) == $examType->id)
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
                            <div>
                                <a href="{{ route('questions.index') }}" class="btn">Batal</a>
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


@push('scripts')
<script>
    ["#question-editor", "#option-a-editor", "#option-b-editor", "#option-c-editor", "#option-d-editor", "#option-e-editor"].forEach(id => {
        new Quill(id, {
            theme: "snow",
        });
    });

    [
        ["question-editor", "question"],
        ["option-a-editor", "option_a"],
        ["option-b-editor", "option_b"],
        ["option-c-editor", "option_c"],
        ["option-d-editor", "option_d"],
        ["option-e-editor", "option_e"]
    ].forEach(id => {
        document.getElementById(id[0]).addEventListener('keyup', function() {
            document.getElementById(id[1]).value = this.querySelector('.ql-editor').innerHTML;
        });
    });
</script>
@endpush