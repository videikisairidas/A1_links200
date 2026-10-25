{{-- links --}}
{{-- pages --}}
@if ($objectPaginate->hasPages())
    <div class="{{ $class }} NavLinks">
        {{-- < --}}
        @if ($objectPaginate->onFirstPage())
            <span class="disabled">&laquo;</span>
        @else
            <a href="{{ $objectPaginate->appends(request()->query())->previousPageUrl() }}">&laquo;</a>
        @endif
        {{-- pages --}}
        @php
            $current = $objectPaginate->currentPage();
            $last = $objectPaginate->lastPage();
        @endphp

        {{-- Always show page 1 --}}
        @if ($current > 2)
            <a href="{{ $objectPaginate->appends(request()->query())->url(1) }}">1</a>
        @endif

        {{-- Left ellipsis --}}
        @if ($current > 3)
            <span class="dots">…</span>
        @endif

        {{-- Page before current --}}
        @if ($current > 1)
            <a href="{{ $objectPaginate->appends(request()->query())->url($current - 1) }}">{{ $current - 1 }}</a>
        @endif

        {{-- Current page --}}
        <span class="active">{{ $current }}</span>

        {{-- Page after current --}}
        @if ($current < $last)
            <a href="{{ $objectPaginate->appends(request()->query())->url($current + 1) }}">{{ $current + 1 }}</a>
        @endif

        {{-- Right ellipsis --}}
        @if ($current < $last - 2)
            <span class="dots">…</span>
        @endif

        {{-- Always show last page --}}
        @if ($current < $last - 1)
            <a href="{{ $objectPaginate->appends(request()->query())->url($last) }}">{{ $last }}</a>
        @endif

        {{-- > --}}
        @if ($objectPaginate->hasMorePages())
            <a href="{{ $objectPaginate->appends(request()->query())->nextPageUrl() }}">&raquo;</a>
        @else
            <span class="disabled">&raquo;</span>
        @endif
    </div>
@endif
