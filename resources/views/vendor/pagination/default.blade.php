@if ($paginator->hasPages())
    <nav class="pagination-nav">
        <ul class="pagination-list">
            @if ($paginator->onFirstPage())
                <li class="pagination-item disabled">
                    <span class="pagination-link pagination-arrow">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                            <path d="M8.5 10.5L5.5 7L8.5 3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </li>
            @else
                <li class="pagination-item">
                    <a href="{{ $paginator->previousPageUrl() }}" class="pagination-link pagination-arrow" rel="prev">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                            <path d="M8.5 10.5L5.5 7L8.5 3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="pagination-item disabled">
                        <span class="pagination-link">{{ $element }}</span>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="pagination-item active">
                                <span class="pagination-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="pagination-item">
                                <a href="{{ $url }}" class="pagination-link">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li class="pagination-item">
                    <a href="{{ $paginator->nextPageUrl() }}" class="pagination-link pagination-arrow" rel="next">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                            <path d="M5.5 3.5L8.5 7L5.5 10.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </li>
            @else
                <li class="pagination-item disabled">
                    <span class="pagination-link pagination-arrow">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                            <path d="M5.5 3.5L8.5 7L5.5 10.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
