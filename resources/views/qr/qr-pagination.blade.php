@if ($qrcodes->hasPages())
    <nav class="flex justify-end mt-6" role="navigation" aria-label="Pagination Navigation">
        <ul class="inline-flex items-center space-x-1">

            {{-- Previous --}}
            @if ($qrcodes->onFirstPage())
                <li>
                    <span class="px-3 py-1 rounded-md bg-gray-200 text-gray-400 cursor-not-allowed select-none">Prev</span>
                </li>
            @else
                <li>
                    <a href="{{ $qrcodes->previousPageUrl() }}"
                       class="page-link px-3 py-1 rounded-md bg-white border border-gray-300 text-gray-700 hover:bg-red-100 transition">
                        Prev
                    </a>
                </li>
            @endif

            {{-- Build compact pager window --}}
            @php
                $last = $qrcodes->lastPage();
                $current = $qrcodes->currentPage();
                // window around current
                $start = max(1, $current - 2);
                $end = min($last, $current + 2);
            @endphp

            {{-- show first + ellipsis when needed --}}
            @if ($start > 1)
                <li>
                    <a href="{{ $qrcodes->url(1) }}"
                       class="page-link px-3 py-1 border rounded bg-white text-gray-700 hover:bg-red-100 transition"
                       data-active="{{ 1 == $current ? '1' : '0' }}">1</a>
                </li>

                @if ($start > 2)
                    <li>
                        <span class="px-3 py-1 border rounded text-gray-400">...</span>
                    </li>
                @endif
            @endif

            {{-- numeric pages in the sliding window --}}
            @for ($i = $start; $i <= $end; $i++)
                <li>
                    <a href="{{ $qrcodes->url($i) }}"
                       class="page-link px-3 py-1 border rounded {{ $i == $current ? 'bg-red-600 text-white border-red-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-red-100 transition' }}"
                       data-active="{{ $i == $current ? '1' : '0' }}">
                        {{ $i }}
                    </a>
                </li>
            @endfor

            {{-- show ellipsis + last when needed --}}
            @if ($end < $last)
                @if ($end < $last - 1)
                    <li>
                        <span class="px-3 py-1 border rounded text-gray-400">...</span>
                    </li>
                @endif

                <li>
                    <a href="{{ $qrcodes->url($last) }}"
                       class="page-link px-3 py-1 border rounded bg-white text-gray-700 hover:bg-red-100 transition"
                       data-active="{{ $last == $current ? '1' : '0' }}">
                        {{ $last }}
                    </a>
                </li>
            @endif

            {{-- Next --}}
            @if ($qrcodes->hasMorePages())
                <li>
                    <a href="{{ $qrcodes->nextPageUrl() }}"
                       class="page-link px-3 py-1 rounded-md bg-white border border-gray-300 text-gray-700 hover:bg-red-100 transition">
                        Next
                    </a>
                </li>
            @else
                <li>
                    <span class="px-3 py-1 rounded-md bg-gray-200 text-gray-400 cursor-not-allowed select-none">Next</span>
                </li>
            @endif

        </ul>
    </nav>
@endif
