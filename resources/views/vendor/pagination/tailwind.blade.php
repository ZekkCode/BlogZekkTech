@if ($paginator->hasPages())
<nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between mt-6">
    <div class="flex justify-between flex-1 sm:hidden">
        @if ($paginator->onFirstPage())
        <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium cursor-default rounded-md min-h-10"
            style="color: var(--text-secondary); background-color: var(--bg-secondary); border: 1px solid var(--border-color);">
            {!! __('pagination.previous') !!}
        </span>
        @else
        <a href="{{ $paginator->previousPageUrl() }}"
            class="relative inline-flex items-center px-4 py-2 text-sm font-medium rounded-md min-h-10 transition-colors"
            style="color: var(--text-secondary); background-color: var(--bg-secondary); border: 1px solid var(--border-color);"
            onmouseover="this.style.color='var(--accent-color)'; this.style.borderColor='var(--accent-color)'"
            onmouseout="this.style.color='var(--text-secondary)'; this.style.borderColor='var(--border-color)'">
            {!! __('pagination.previous') !!}
        </a>
        @endif

        @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}"
            class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium rounded-md min-h-10 transition-colors"
            style="color: var(--text-secondary); background-color: var(--bg-secondary); border: 1px solid var(--border-color);"
            onmouseover="this.style.color='var(--accent-color)'; this.style.borderColor='var(--accent-color)'"
            onmouseout="this.style.color='var(--text-secondary)'; this.style.borderColor='var(--border-color)'">
            {!! __('pagination.next') !!}
        </a>
        @else
        <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium cursor-default rounded-md min-h-10"
            style="color: var(--text-secondary); background-color: var(--bg-secondary); border: 1px solid var(--border-color);">
            {!! __('pagination.next') !!}
        </span>
        @endif
    </div>

    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
        <div>
            <p class="text-sm leading-5" style="color: var(--text-secondary);">
                {!! __('Showing') !!}
                @if ($paginator->firstItem())
                <span class="font-medium">{{ $paginator->firstItem() }}</span>
                {!! __('to') !!}
                <span class="font-medium">{{ $paginator->lastItem() }}</span>
                @else
                {{ $paginator->count() }}
                @endif
                {!! __('of') !!}
                <span class="font-medium">{{ $paginator->total() }}</span>
                {!! __('results') !!}
            </p>
        </div>

        <div>
            <span class="relative z-0 inline-flex shadow-sm rounded-md">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                    <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium cursor-default rounded-l-md min-h-10"
                        style="color: var(--text-secondary); background-color: var(--bg-secondary); border: 1px solid var(--border-color);"
                        aria-hidden="true">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </span>
                @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                    class="relative inline-flex items-center px-2 py-2 text-sm font-medium rounded-l-md min-h-10 transition-colors"
                    style="color: var(--text-secondary); background-color: var(--bg-secondary); border: 1px solid var(--border-color);"
                    onmouseover="this.style.color='var(--accent-color)'; this.style.borderColor='var(--accent-color)'"
                    onmouseout="this.style.color='var(--text-secondary)'; this.style.borderColor='var(--border-color)'"
                    aria-label="{{ __('pagination.previous') }}">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                <span aria-disabled="true">
                    <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium cursor-default min-h-10"
                        style="color: var(--text-secondary); background-color: var(--bg-secondary); border: 1px solid var(--border-color);">{{ $element }}</span>
                </span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                <span aria-current="page">
                    <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium cursor-default min-h-10"
                        style="color: white; background-color: var(--accent-color); border: 1px solid var(--accent-color);">{{ $page }}</span>
                </span>
                @else
                <a href="{{ $url }}"
                    class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium min-h-10 transition-colors"
                    style="color: var(--text-secondary); background-color: var(--bg-secondary); border: 1px solid var(--border-color);"
                    onmouseover="this.style.color='var(--accent-color)'; this.style.borderColor='var(--accent-color)'"
                    onmouseout="this.style.color='var(--text-secondary)'; this.style.borderColor='var(--border-color)'"
                    aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                    {{ $page }}
                </a>
                @endif
                @endforeach
                @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                    class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium rounded-r-md min-h-10 transition-colors"
                    style="color: var(--text-secondary); background-color: var(--bg-secondary); border: 1px solid var(--border-color);"
                    onmouseover="this.style.color='var(--accent-color)'; this.style.borderColor='var(--accent-color)'"
                    onmouseout="this.style.color='var(--text-secondary)'; this.style.borderColor='var(--border-color)'"
                    aria-label="{{ __('pagination.next') }}">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
                @else
                <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                    <span class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium cursor-default rounded-r-md min-h-10"
                        style="color: var(--text-secondary); background-color: var(--bg-secondary); border: 1px solid var(--border-color);"
                        aria-hidden="true">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </span>
                @endif
            </span>
        </div>
    </div>
</nav>
@endif