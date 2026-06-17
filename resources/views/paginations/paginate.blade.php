@if ($paginator->hasPages())
    <nav>
        {{-- Стрелка назад --}}
        @if ($paginator->onFirstPage())
            <span class="pagination-arrow disabled">←</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="pagination-arrow">←</a>
        @endif

        {{-- Страницы --}}
        @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
            @if ($page == $paginator->currentPage())
                <span class="pagination-current">{{ $page }}</span>
            @else
                <a href="{{ $url }}" class="pagination-link">{{ $page }}</a>
            @endif
        @endforeach

        {{-- Стрелка вперед --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="pagination-arrow">→</a>
        @else
            <span class="pagination-arrow disabled">→</span>
        @endif
    </nav>
@endif
