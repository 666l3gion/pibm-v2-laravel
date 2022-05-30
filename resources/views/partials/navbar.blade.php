<div class="progress d-none position-absolute top-0 start-0 end-0" id="progress-bar-app"
    style="height: 2px !important; z-index: 9999 !important;">
    <div class="progress-bar progress-bar-indeterminate bg-info"></div>
</div>

<header class="navbar navbar-expand-md navbar-light d-print-none">
    <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand d-none-navbar-horizontal pe-0 pe-md-3">
            <a href="{{ route('dashboard.index') }}">
                <img src="{{ asset('images/logo.png') }}" width="110" height="32" alt="SMK Logo"
                    class="navbar-brand-image d-inline-block me-2">
                eLearning
            </a>
        </h1>
        <div class="navbar-nav flex-row order-md-last">
            <div class="d-none d-md-flex me-3">
                <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode"
                    data-bs-toggle="tooltip" data-bs-placement="bottom">
                    <!-- Download SVG icon from http://tabler-icons.io/i/moon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" />
                    </svg>
                </a>
                <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode"
                    data-bs-toggle="tooltip" data-bs-placement="bottom">
                    <!-- Download SVG icon from http://tabler-icons.io/i/sun -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <circle cx="12" cy="12" r="4" />
                        <path
                            d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" />
                    </svg>
                </a>
            </div>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                    aria-label="Open user menu">
                    <span class="avatar avatar-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <circle cx="12" cy="7" r="4" />
                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                        </svg>
                    </span>
                    <div class="d-none d-xl-block ps-2">
                        <div>{{ auth()->user()->name }}</div>
                        <div class="mt-1 small fw-bold text-success">{{ Str::ucfirst(auth()->user()->role) }}
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <div class="p-2 text-center">
                        <h5 class="small mb-1">{{ auth()->user()->name }} ~ <span class="text-success">{{
                                Str::ucfirst(auth()->user()->role) }}</span></h5>
                        <small class="small">{{ auth()->user()->email }}</small>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('dashboard.users.edit', ['user' => auth()->user()->id]) }}"
                        class="dropdown-item">Edit Profile</a>
                    <div class="dropdown-divider"></div>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="dropdown-item btn-danger">Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="navbar-expand-md">
    <div class="collapse navbar-collapse" id="navbar-menu">
        <!-- .navbar-overflow in main.css -->
        <div class="navbar navbar-light">
            <div class="container-xl">
                <ul class="navbar-nav navbar-overflow">

                    <li class="nav-item {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('dashboard.index') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <circle cx="12" cy="13" r="2" />
                                    <line x1="13.45" y1="11.55" x2="15.5" y2="9.5" />
                                    <path d="M6.4 20a9 9 0 1 1 11.2 0z" />
                                </svg>
                            </span>
                            <span class="nav-link-title">
                                Dashboard
                            </span>
                        </a>
                    </li>

                    @if (auth()->user()->isSuperadminOrAdmin())
                    <li class="nav-item dropdown {{ request()->routeIs('master.*') ? 'active' : '' }}">
                        <a class="nav-link dropdown-toggle" href="#navbar-extra" data-bs-toggle="dropdown"
                            data-bs-auto-close="outside" role="button" aria-expanded="false">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <!-- Download SVG icon from http://tabler-icons.io/i/folders -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M9 4h3l2 2h5a2 2 0 0 1 2 2v7a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2" />
                                    <path d="M17 17v2a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2h2" />
                                </svg>
                            </span>
                            <span class="nav-link-title">
                                Master
                            </span>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item {{ request()->routeIs('master.teachers.*') ? 'active' : '' }}"
                                href="{{ route('master.teachers.index') }}">
                                Guru
                            </a>
                            <a class="dropdown-item {{ request()->routeIs('master.majors.*') ? 'active' : '' }}"
                                href="{{ route('master.majors.index') }}">
                                Jurusan
                            </a>
                            <a class="dropdown-item {{ request()->routeIs('master.classes.*') ? 'active' : '' }}"
                                href="{{ route('master.classes.index') }}">
                                Kelas
                            </a>
                            <a class="dropdown-item {{ request()->routeIs('master.subjects.*') ? 'active' : '' }}"
                                href="{{ route('master.subjects.index') }}">
                                Mata Pelajaran
                            </a>
                            <a class="dropdown-item {{ request()->routeIs('master.students.*') ? 'active' : '' }}"
                                href="{{ route('master.students.index') }}">
                                Siswa
                            </a>
                        </div>
                    </li>

                    <li class="nav-item dropdown {{ request()->routeIs('relations.*') ? 'active' : '' }}">
                        <a class="nav-link dropdown-toggle" href="#navbar-extra" data-bs-toggle="dropdown"
                            data-bs-auto-close="outside" role="button" aria-expanded="false">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <!-- Download SVG icon from http://tabler-icons.io/i/link -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M10 14a3.5 3.5 0 0 0 5 0l4 -4a3.5 3.5 0 0 0 -5 -5l-.5 .5" />
                                    <path d="M14 10a3.5 3.5 0 0 0 -5 0l-4 4a3.5 3.5 0 0 0 5 5l.5 -.5" />
                                </svg>
                            </span>
                            <span class="nav-link-title">
                                Relasi
                            </span>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item {{ request()->routeIs('relations.class-teacher.*') ? 'active' : '' }}"
                                href="{{ route('relations.class-teacher.index') }}">
                                Kelas & Guru
                            </a>
                            <a class="dropdown-item {{ request()->routeIs('relations.class-student.*') ? 'active' : '' }}"
                                href="{{ route('relations.class-student.index') }}">
                                Kelas & Siswa
                            </a>
                            <a class="dropdown-item {{ request()->routeIs('relations.major-subject.*') ? 'active' : '' }}"
                                href="{{ route('relations.major-subject.index') }}">
                                Mata Pelajaran & Jurusan
                            </a>
                            <a class="dropdown-item {{ request()->routeIs('relations.subject-teacher.*') ? 'active' : '' }}"
                                href="{{ route('relations.subject-teacher.index') }}">
                                Guru & Mata Pelajaran
                            </a>
                        </div>
                    </li>
                    @endif

                    @if (auth()->user()->isSuperadmin())
                    <li class="nav-item {{ request()->routeIs('dashboard.users.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('dashboard.users.index') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <!-- Download SVG icon from http://tabler-icons.io/i/users -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <circle cx="9" cy="7" r="4" />
                                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                    <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                                </svg>
                            </span>
                            <span class="nav-link-title">
                                Users Management
                            </span>
                        </a>
                    </li>
                    @endif

                    @if (auth()->user()->isSuperadminOrAdmin())
                    <li class="nav-item {{ request()->routeIs('exam-types.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('exam-types.index') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <!-- Download SVG icon from http://tabler-icons.io/i/users -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <circle cx="9" cy="7" r="4" />
                                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                    <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                                </svg>
                            </span>
                            <span class="nav-link-title">
                                Jenis Ujian
                            </span>
                        </a>
                    </li>
                    @endif

                    @if (auth()->user()->isSuperadminOrAdmin() || auth()->user()->isTeacher())
                    <li class="nav-item {{ request()->routeIs('questions.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('questions.index') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <!-- Download SVG icon from http://tabler-icons.io/i/users -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <circle cx="9" cy="7" r="4" />
                                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                    <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                                </svg>
                            </span>
                            <span class="nav-link-title">
                                Soal
                            </span>
                        </a>
                    </li>
                    @endif

                    @if (auth()->user()->isTeacher() || auth()->user()->isStudent())
                    <li class="nav-item {{ request()->routeIs('exams.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('exams.index') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <!-- Download SVG icon from http://tabler-icons.io/i/users -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <circle cx="9" cy="7" r="4" />
                                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                    <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                                </svg>
                            </span>
                            <span class="nav-link-title">
                                Ujian
                            </span>
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="container-xl my-2">
    <!-- alert -->
    <div class="w-100">
        @include('partials.alert')
    </div>
</div>