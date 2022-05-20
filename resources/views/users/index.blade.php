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
                        <x-filters.sort route="dashboard.users.index" :sorts="
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
                                'text' => 'Nama'
                            ],
                            [
                                'sort' => 'email',
                                'direction' => 'asc',
                                'text' => 'Email'
                            ],
                            [
                                'sort' => 'role',
                                'direction' => 'asc',
                                'text' => 'Level'
                    ],
                            [
                                'sort' => 'is_active',
                                'direction' => 'asc',
                                'text' => 'Status'
                            ]
                        ]" />
                        <x-filters.search route="dashboard.users.index" />
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap datatable">
                        <thead>
                            <tr>
                                <th class="w-1">No.</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Level</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if( $users->isNotEmpty() )
                            @foreach($users as $user)
                            <tr>
                                <td><span class="text-muted">{{ ($users->currentpage()-1) * $users->perpage() +
                                        $loop->index + 1 }}</span></td>
                                <td>
                                    {{ $user->name }}
                                </td>
                                <td>
                                    {{ $user->email }}
                                </td>
                                <td>
                                    @if ($user->is_active)
                                    <div class="badge bg-green text-uppercase">Aktif</div>
                                    @else
                                    <div class="badge bg-danger text-uppercase">Tidak Aktif</div>
                                    @endif
                                </td>
                                <td>
                                    <div class="badge bg-green text-uppercase">{{ $user->role }}</div>
                                </td>
                                <td class="text-center">
                                    <span class="dropdown">
                                        <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport"
                                            data-bs-toggle="dropdown">Aksi</button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <form action="{{ route('dashboard.users.destroy', ['user' => $user->id]) }}"
                                                method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"
                                                    class="dropdown-item btn-danger">
                                                    Hapus
                                                </button>
                                            </form>
                                            <a class="dropdown-item"
                                                href="{{ route('dashboard.users.edit', ['user' => $user->id]) }}">
                                                Edit
                                            </a>
                                        </div>
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="8">
                                    <p class="text-danger py-3 m-0 text-center">Data users tidak ditemukan.</p>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="card-footer d-flex align-items-center justify-content-between">
                    {{ $users->onEachSide(5)->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection