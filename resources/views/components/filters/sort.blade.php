@props(['sorts' => [], 'route'])

<div class="dropdown d-flex me-3">
    <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1">
        <!-- Download SVG icon from http://tabler-icons.io/i/sort-descending-2 -->
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
            stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <rect x="5" y="5" width="5" height="5" rx=".5" />
            <rect x="5" y="14" width="5" height="5" rx=".5" />
            <path d="M14 15l3 3l3 -3" />
            <path d="M17 18v-12" />
        </svg>
    </a>
    <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
        <div class="card">
            <div class="card-header py-2">
                <small>Urutkan</small>
            </div>
            @foreach ($sorts as $sort)
            <?php
                // to handle blade formatter bug
                $queryStrings = [
                    "sort" => $sort['sort'],
                    "direction" => $sort['direction'],
                    "search" => request('search')
                ];
            ?>
            <a href="{{ route($route, $queryStrings) }}" class="dropdown-item p-3">{{ $sort['text'] }}</a>
            @endforeach
        </div>
    </div>
</div>