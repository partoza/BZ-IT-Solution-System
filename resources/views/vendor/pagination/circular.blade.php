{{-- pagination circular view --}}
@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="inline-flex items-center gap-2">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="w-8 h-8 inline-flex items-center justify-center text-gray-400 border rounded-full bg-gray-50">«</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
               class="w-8 h-8 inline-flex items-center justify-center text-gray-700 border rounded-full hover:bg-gray-100">«</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="px-2 text-gray-500">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a href="{{ $url }}" aria-current="page"
                           class="w-8 h-8 inline-flex items-center justify-center bg-primary text-white border rounded-full font-medium">{{ $page }}</a>
                    @else
                        <a href="{{ $url }}"
                           class="w-8 h-8 inline-flex items-center justify-center text-gray-700 border rounded-full hover:bg-gray-100">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
               class="w-8 h-8 inline-flex items-center justify-center text-gray-700 border rounded-full hover:bg-gray-100">»</a>
        @else
            <span class="w-8 h-8 inline-flex items-center justify-center text-gray-400 border rounded-full bg-gray-50">»</span>
        @endif
    </nav>
@endif