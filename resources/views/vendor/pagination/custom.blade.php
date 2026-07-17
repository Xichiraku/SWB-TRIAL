 @if ($paginator->hasPages())
<ul class="inline-flex items-center gap-1">
    {{-- Previous --}}
    <li>
        @if ($paginator->onFirstPage())
            <span class="px-3 py-1.5 text-sm text-gray-300 bg-white border border-gray-200 rounded-lg cursor-not-allowed">&laquo;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1.5 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">&laquo;</a>
        @endif
    </li>

    @php
        $currentPage = $paginator->currentPage();
        $lastPage = $paginator->lastPage();
    @endphp

    @if ($currentPage > 2)
        <li>
            <a href="{{ $paginator->url(1) }}" class="px-3 py-1.5 text-sm border rounded-lg {{ $currentPage === 1 ? 'bg-[#1F4D1F] text-white border-[#1F4D1F]' : 'text-gray-600 bg-white border-gray-300 hover:bg-gray-50' }}">1</a>
        </li>
        @if ($currentPage > 3)
            <li><span class="px-2 py-1.5 text-sm text-gray-400">...</span></li>
        @endif
    @endif

    @for ($i = max(1, $currentPage - 1); $i <= min($lastPage, $currentPage + 1); $i++)
        <li>
            <a href="{{ $paginator->url($i) }}" class="px-3 py-1.5 text-sm border rounded-lg {{ $currentPage === $i ? 'bg-[#1F4D1F] text-white border-[#1F4D1F]' : 'text-gray-600 bg-white border-gray-300 hover:bg-gray-50' }}">{{ $i }}</a>
        </li>
    @endfor

    @if ($currentPage < $lastPage - 1)
        @if ($currentPage < $lastPage - 2)
            <li><span class="px-2 py-1.5 text-sm text-gray-400">...</span></li>
        @endif
        <li>
            <a href="{{ $paginator->url($lastPage) }}" class="px-3 py-1.5 text-sm border rounded-lg {{ $currentPage === $lastPage ? 'bg-[#1F4D1F] text-white border-[#1F4D1F]' : 'text-gray-600 bg-white border-gray-300 hover:bg-gray-50' }}">{{ $lastPage }}</a>
        </li>
    @endif

    {{-- Next --}}
    <li>
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1.5 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">&raquo;</a>
        @else
            <span class="px-3 py-1.5 text-sm text-gray-300 bg-white border border-gray-200 rounded-lg cursor-not-allowed">&raquo;</span>
        @endif
    </li>
</ul>
@endif
