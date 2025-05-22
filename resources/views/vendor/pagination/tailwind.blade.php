@if ($paginator->hasPages())
<nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">

  {{-- Kiri: Showing x to y of z results --}}
  <div class="text-sm text-gray-700">
    {!! __('Showing') !!}
    @if ($paginator->firstItem())
      <span class="font-semibold">{{ $paginator->firstItem() }}</span> {!! __('to') !!}
      <span class="font-semibold">{{ $paginator->lastItem() }}</span>
    @else
      {{ $paginator->count() }}
    @endif
    {!! __('of') !!}
    <span class="font-semibold">{{ $paginator->total() }}</span>
    {!! __('results') !!}
  </div>

  {{-- Kanan: Pagination --}}
  <div>
    <span class="relative z-0 inline-flex rounded-md shadow-sm">
      {{-- Previous Page Link --}}
      @if ($paginator->onFirstPage())
        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-blue-400 bg-white border border-blue-300 cursor-not-allowed rounded-l-md select-none">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
            <polyline points="15 18 9 12 15 6"></polyline>
          </svg>
        </span>
      @else
        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-blue-600 bg-white border border-blue-300 rounded-l-md hover:bg-blue-100 hover:text-blue-700 focus:z-10 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 active:bg-blue-200 active:text-blue-800 transition" aria-label="{{ __('pagination.previous') }}">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
            <polyline points="15 18 9 12 15 6"></polyline>
          </svg>
        </a>
      @endif

      @php
        $currentPage = $paginator->currentPage();
        $lastPage = $paginator->lastPage();
        $start = max(1, $currentPage - 2);
        $end = min($lastPage, $currentPage + 2);
      @endphp

      {{-- First page --}}
      @if ($start > 1)
        <a href="{{ $paginator->url(1) }}" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-blue-600 bg-white border border-blue-300 hover:bg-blue-100 hover:text-blue-700 focus:z-10 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 active:bg-blue-200 active:text-blue-800 transition" aria-label="Go to page 1">1</a>
        @if ($start > 2)
          <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-400 bg-white border border-blue-300 cursor-default select-none">...</span>
        @endif
      @endif

      {{-- Pages around current page --}}
      @for ($page = $start; $page <= $end; $page++)
        @if ($page == $currentPage)
          <span aria-current="page" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-semibold text-white bg-blue-600 border border-blue-600 cursor-default select-none">{{ $page }}</span>
        @else
          <a href="{{ $paginator->url($page) }}" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-blue-600 bg-white border border-blue-300 hover:bg-blue-100 hover:text-blue-700 focus:z-10 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 active:bg-blue-200 active:text-blue-800 transition" aria-label="Go to page {{ $page }}">{{ $page }}</a>
        @endif
      @endfor

      {{-- Last page --}}
      @if ($end < $lastPage)
        @if ($end < $lastPage - 1)
          <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-400 bg-white border border-blue-300 cursor-default select-none">...</span>
        @endif
        <a href="{{ $paginator->url($lastPage) }}" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-blue-600 bg-white border border-blue-300 hover:bg-blue-100 hover:text-blue-700 focus:z-10 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 active:bg-blue-200 active:text-blue-800 transition" aria-label="Go to page {{ $lastPage }}">{{ $lastPage }}</a>
      @endif

      {{-- Next Page Link --}}
      @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-3 py-2 -ml-px text-sm font-medium text-blue-600 bg-white border border-blue-300 rounded-r-md hover:bg-blue-100 hover:text-blue-700 focus:z-10 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 active:bg-blue-200 active:text-blue-800 transition" aria-label="{{ __('pagination.next') }}">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
            <polyline points="9 18 15 12 9 6"></polyline>
          </svg>
        </a>
      @else
        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}" class="relative inline-flex items-center px-3 py-2 -ml-px text-sm font-medium text-blue-400 bg-white border border-blue-300 cursor-not-allowed rounded-r-md select-none">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
            <polyline points="9 18 15 12 9 6"></polyline>
          </svg>
        </span>
      @endif
    </span>
  </div>
</nav>
@endif
