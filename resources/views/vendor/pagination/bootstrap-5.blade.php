@if ($paginator->hasPages())
    <nav class="d-flex align-items-center justify-content-between flex-wrap gap-2">
        {{-- Left: Showing text --}}
        <div class="small text-muted">
            {{ __('Menampilkan') }}
            <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
            -
            <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
            {{ __('dari') }}
            <span class="fw-semibold">{{ $paginator->total() }}</span>
            {{ __('data') }}
        </div>

        {{-- Right: Pagination buttons --}}
        <ul class="pagination mb-0">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled"><span class="page-link">&lsaquo;</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&lsaquo;</a></li>
            @endif

            {{-- Page Numbers --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">&rsaquo;</a></li>
            @else
                <li class="page-item disabled"><span class="page-link">&rsaquo;</span></li>
            @endif
        </ul>
    </nav>
@endif
