@props(['route', 'parameters' => []])

<div class="text-muted flex-fill">
    <form method="GET" @if(count($parameters)> 0) action="{{ route($route, $parameters) }}" @else action="{{
        route($route) }}"
        @endif class="input-icon">
        <input type="text" value="{{ request('search') }}" class="form-control w-100" placeholder="Search…"
            name="search" autocomplete="off">
        <input type="hidden" name="sort" value="{{ request('sort') }}">
        <input type="hidden" name="direction" value="{{ request('direction') }}">
        <span class="input-icon-addon">
            <!-- Download SVG icon from http://tabler-icons.io/i/search -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <circle cx="10" cy="10" r="7" />
                <line x1="21" y1="21" x2="15" y2="15" />
            </svg>
        </span>
    </form>
</div>