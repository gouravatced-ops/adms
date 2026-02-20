<style>
    .custom-pagination-wrapper {
        display: flex;
        justify-content: center;
        gap: 8px;
        align-items: center;
    }

    .page-btn {
        padding: 6px 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        text-decoration: none;
        color: #333;
        font-size: 14px;
        transition: 0.2s;
    }

    .page-btn:hover {
        background: #f2f2f2;
    }

    .page-btn.active {
        background: #4f46e5;
        color: #fff;
        border-color: #4f46e5;
    }

    .page-btn.disabled {
        color: #aaa;
        pointer-events: none;
    }

    .page-dots {
        padding: 6px;
    }
</style>
@if ($paginator->hasPages())
    <nav class="custom-pagination-wrapper">

        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span class="page-btn disabled">Previous</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="page-btn">Previous</a>
        @endif

        {{-- Page Numbers --}}
        @foreach ($elements as $element)
            {{-- Separator --}}
            @if (is_string($element))
                <span class="page-dots">{{ $element }}</span>
            @endif

            {{-- Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="page-btn active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="page-btn">Next</a>
        @else
            <span class="page-btn disabled">Next</span>
        @endif

    </nav>
@endif
