@if ($qrcodes->hasPages())
    <nav>
        <ul class="flex gap-2 justify-end">
            {{-- Previous Button --}}
            @if ($qrcodes->onFirstPage())
                <li>
                    <span class="px-3 py-1 rounded border border-gray-300 text-gray-400 cursor-not-allowed select-none">Prev</span>
                </li>
            @else
                <li>
                    <a href="{{ $qrcodes->previousPageUrl() }}"
                       class="page-link px-3 py-1 rounded border border-gray-300 bg-white text-gray-700 hover:bg-red-100 hover:text-red-700 transition shadow-sm">
                        Prev
                    </a>
                </li>
            @endif

            {{-- Page Numbers --}}
            @foreach ($qrcodes->links()->elements[0] as $page => $url)
                <li>
                    <a href="{{ $url }}"
                       class="page-link px-3 py-1 rounded border font-semibold transition shadow-sm {{ $qrcodes->currentPage() == $page ? 'bg-red-600 text-white border-red-600' : 'bg-white text-gray-700 hover:bg-red-100 hover:text-red-700' }}"
                       data-active="{{ $qrcodes->currentPage() == $page ? 1 : 0 }}">
                        {{ $page }}
                    </a>
                </li>
            @endforeach

            {{-- Next Button --}}
            @if ($qrcodes->hasMorePages())
                <li>
                    <a href="{{ $qrcodes->nextPageUrl() }}"
                       class="page-link px-3 py-1 rounded border border-gray-300 bg-white text-gray-700 hover:bg-red-100 hover:text-red-700 transition shadow-sm">
                        Next
                    </a>
                </li>
            @else
                <li>
                    <span class="px-3 py-1 rounded border border-gray-300 text-gray-400 cursor-not-allowed select-none">Next</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
