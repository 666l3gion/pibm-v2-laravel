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
        <div class="col">
            <div class="card">
                <div class="card-header row">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <h3 class="card-title">Daftar {{ $title }}</h3>
                    </div>
                    <div class="col-md-6 d-flex align-items-center">
                        <x-filters.sort route="exam-results.index" :parameters="['exam' => $exam->id]" :sorts="
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
                            'sort' => 'score',
                            'direction' => 'desc',
                            'text' => 'Nilai Tertinggi'
                            ],
                            [
                            'sort' => 'score',
                            'direction' => 'asc',
                            'text' => 'Nilai Terendah'
                            ],
                            [
                            'sort' => 'total_right_answer',
                            'direction' => 'desc',
                            'text' => 'Jumlah Benar Terbanyak'
                            ],
                            [
                            'sort' => 'total_right_answer',
                            'direction' => 'asc',
                            'text' => 'Jumlah Benar Palihg Sedikit'
                            ],
                            [
                            'sort' => 'start_time',
                            'direction' => 'desc',
                            'text' => 'Siswa Memulai Paling Cepat'
                            ],
                            [
                            'sort' => 'start_time',
                            'direction' => 'asc',
                            'text' => 'Siswa Memulai Paling Lama'
                            ],
                            [
                            'sort' => 'end_time',
                            'direction' => 'desc',
                            'text' => 'Siswa Selesai Ujian Paling Cepat'
                            ],
                            [
                            'sort' => 'end_time',
                            'direction' => 'asc',
                            'text' => 'Siswa Selesai Ujian Paling Lamas'
                            ],
                            ]" />
                        <x-filters.search route="exam-results.index" :parameters="['exam' => $exam->id]" />
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap datatable">
                        <thead>
                            <tr>
                                <th class="w-1">No.</th>
                                <th>Siswa</th>
                                <th>Nilai</th>
                                <th>Jumlah Benar</th>
                                <th>Status</th>
                                <th>Siswa Memulai Ujian</th>
                                <th>Siswa Mengakhiri Ujian</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if( $examResults->isNotEmpty() )
                            @foreach($examResults as $examResult)
                            <tr>
                                <td><span class="text-muted">{{ ($examResults->currentpage()-1) *
                                        $examResults->perpage() +
                                        $loop->index + 1 }}</span></td>
                                <td>
                                    {{ $examResult->student->name }}
                                </td>
                                <td>
                                    {{ $examResult->score }}
                                </td>
                                <td>
                                    {{ $examResult->total_right_answer }}
                                </td>
                                <td>
                                    @if ($examResult->status)
                                    <div class="badge bg-success">Selesai</div>
                                    @else
                                    <div class="badge badge-danger">Belum Selesai</div>
                                    @endif
                                </td>
                                <td>
                                    {{ $examResult->start_time }}
                                </td>
                                <td>
                                    {{ $examResult->end_time }}
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="8">
                                    <p class="text-danger py-3 m-0 text-center">Data hasil ujian belum ada.</p>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="card-footer d-flex align-items-center justify-content-between">
                    {{ $examResults->onEachSide(5)->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection