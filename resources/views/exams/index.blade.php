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

            @can('create', App\Models\Exam::class)
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('exams.create') }}" class="btn btn-primary">
                        <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                        Tambah Data Ujian
                    </a>
                </div>
            </div>
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header row">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <h3 class="card-title">Daftar {{ $title }}</h3>
                    </div>
                    <div class="col-md-6 d-flex align-items-center">
                        <x-filters.sort route="exams.index" :sorts="
                        [
                            [
                                'sort' => 'created_at',
                                'direction' => 'desc',
                                'text' => 'Terbaru'
                            ],
                            [
                                'sort' => 'created_at',
                                'direction' => 'asc',
                                'text' => 'Terlama'
                            ],
                            [
                                'sort' => 'name',
                                'direction' => 'asc',
                                'text' => 'Nama Ujian'
                            ],
                            [
                                'sort' => 'total_question',
                                'direction' => 'asc',
                                'text' => 'Jumlah Soal'
                            ],
                            [
                                'sort' => 'start_date',
                                'direction' => 'desc',
                                'text' => 'Tanggal Mulai'
                            ],
                            [
                                'sort' => 'end_date',
                                'direction' => 'desc',
                                'text' => 'Tanggal Berakhir'
                            ],
                            [
                                'sort' => 'time',
                                'direction' => 'asc',
                                'text' => 'Waktu'
                            ]
                        ]" />
                        <x-filters.search route="exams.index" />
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap datatable">
                        <thead>
                            <tr>
                                <th class="w-1">No.</th>
                                <th>Guru</th>
                                <th>Mata Pelajaran</th>
                                <th>Kelas</th>
                                <th>Nama Ujian</th>
                                <th>Jumlah Soal</th>
                                <th>Tanggal Mulai - Tanggal Berakhir</th>
                                <th>Waktu</th>
                                @if (auth()->user()->isTeacher())
                                <th>Token</th>
                                @endif
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if( $exams->isNotEmpty() )
                            @foreach($exams as $exam)
                            <tr>
                                <td><span class="text-muted">{{ ($exams->currentpage()-1) * $exams->perpage() +
                                        $loop->index + 1 }}</span></td>
                                <td>
                                    {{ $exam->teacher->name }}
                                </td>
                                <td>
                                    {{ $exam->subject->name }}
                                </td>
                                <td>
                                    {{ $exam->class->name }}
                                </td>
                                <td>
                                    {{ $exam->name }}
                                </td>
                                <td>
                                    {{ $exam->total_question }}
                                </td>
                                <td>
                                    {{ $exam->start_date }} - {{ $exam->end_date }}
                                </td>
                                <td>
                                    {{ $exam->time }} Menit
                                </td>
                                @if (auth()->user()->isTeacher())
                                <td>
                                    {{ $exam->token }}
                                </td>
                                @endif
                                <td class="text-center">
                                    <span class="dropdown">
                                        <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport"
                                            data-bs-toggle="dropdown">Aksi</button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            @can('delete', $exam)
                                            <form action="{{ route('exams.destroy', ['exam' => $exam->id]) }}"
                                                method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"
                                                    class="dropdown-item btn-danger">
                                                    Hapus
                                                </button>
                                            </form>
                                            @endcan
                                            @can('view', $exam)
                                            <a class="dropdown-item"
                                                href="{{ route('exams.show', ['exam' => $exam->id]) }}">
                                                Ikuti Ujian
                                            </a>
                                            @endcan
                                            @can('update', $exam)
                                            <a class="dropdown-item"
                                                href="{{ route('exams.edit', ['exam' => $exam->id]) }}">
                                                Edit
                                            </a>
                                            @endcan
                                        </div>
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="8">
                                    <p class="text-danger py-3 m-0 text-center">Data ujian tidak ditemukan.</p>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="card-footer d-flex align-items-center justify-content-between">
                    {{ $exams->onEachSide(5)->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection