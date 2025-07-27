@php
if (! isset($scrollTo)) {
    $scrollTo = 'body';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
       (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
    JS
    : '';
@endphp

<div>
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
            <div class="flex justify-between flex-1 items-center">
                {{-- Teks "Showing results" --}}
                <div class="hidden sm:block">
                    <p class="text-sm text-gray-700 leading-5">
                        Showing
                        <span class="font-medium">{{ $paginator->firstItem() }}</span>
                        to
                        <span class="font-medium">{{ $paginator->lastItem() }}</span>
                        of
                        <span class="font-medium">{{ $paginator->total() }}</span>
                        results
                    </p>
                </div>

                {{-- Link Paginasi --}}
                <div class="flex items-center space-x-1">
                    {{-- Previous Page Link --}}
                    <span>
                        @if ($paginator->onFirstPage())
                            <span class="relative inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-400 bg-white border border-gray-300 cursor-default rounded-md">Previous</span>
                        @else
                            <button wire:click="previousPage" class="relative inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">Previous</button>
                        @endif
                    </span>

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <span class="relative inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-400 bg-white border border-gray-300 cursor-default rounded-md">{{ $element }}</span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span class="relative inline-flex items-center px-3 py-1.5 text-sm font-semibold text-white bg-blue-600 border border-blue-600 cursor-default rounded-md">{{ $page }}</span>
                                @else
                                    <button wire:click="gotoPage({{ $page }})" class="relative inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">{{ $page }}</button>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    <span>
                        @if ($paginator->hasMorePages())
                            <button wire:click="nextPage" class="relative inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">Next</button>
                        @else
                            <span class="relative inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-400 bg-white border border-gray-300 cursor-default rounded-md">Next</span>
                        @endif
                    </span>
                </div>
            </div>
        </nav>
    @endif
</div>
