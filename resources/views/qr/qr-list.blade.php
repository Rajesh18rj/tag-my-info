@extends('layouts.new-layout')

@section('content')
    <div class="max-w-7xl mx-auto py-8 px-0">
        <div class="flex items-center mb-2 border-b pb-4">
            <span class="bg-red-100 text-red-600 rounded-xl p-3 mr-4 shadow-sm">
                <i class="fa fa-qrcode text-xl"></i>
            </span>
            <h2 class="text-2xl font-bold text-gray-800 tracking-wide">
                All <span class="text-red-600">QR Codes</span>
            </h2>
        </div>


        @if(session('success'))
            <div class="mb-4 p-3 rounded bg-green-50 text-green-700 border border-green-200">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-3 rounded bg-red-50 text-red-700 border border-red-200">
                {{ session('error') }}
            </div>
        @endif

        <div class="flex justify-between">
            <!-- Generate QR Code Button -->
            <div class="mt-4 mb-10">
                <a href="{{ route('qr.qr-batches.index') }}"
                   class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white
              px-4 py-2 sm:px-6 sm:py-3 rounded-lg font-semibold shadow-md hover:shadow-lg
              transition-all duration-300 text-sm sm:text-base w-full sm:w-auto">
                    <i class="fas fa-cog"></i>
                    <span>Generate QR Codes</span>
                </a>
            </div>


            <div class="mb-6 flex flex-wrap items-center gap-4 p-4 bg-gradient-to-r from-gray-50 to-white rounded-xl border border-red-200 shadow-sm">

                <!-- 🔍 Search by UID -->
                <div class="flex items-center gap-2">
                    <label for="uidSearch" class="font-semibold text-gray-700 text-sm whitespace-nowrap">
                        <i class="fas fa-search text-red-600 mr-1"></i>
                        Search UID:
                    </label>
                    <div class="relative">
                        <!-- Search Icon Inside -->
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-hashtag text-red-400 text-xs"></i>
                        </div>

                        <!-- Compact Input Field -->
                        <input type="text"
                               id="uidSearch"
                               placeholder="Enter UID..."
                               class="w-48 pl-8 pr-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 bg-white placeholder-gray-400
                          focus:border-red-500 focus:ring-2 focus:ring-red-100 focus:outline-none
                          transition-all duration-300 font-medium shadow-sm hover:shadow-md hover:border-red-400"
                        />
                    </div>
                </div>

                <!-- Divider -->
                <div class="h-8 w-px bg-gray-300"></div>

                <!-- 🎯 Filter by Type -->
                <div class="flex items-center gap-2">
                    <label for="typeFilter" class="font-semibold text-gray-700 text-sm whitespace-nowrap">
                        <i class="fas fa-filter text-red-600 mr-1"></i>
                        Filter Type:
                    </label>
                    <div class="relative">
                        <!-- Custom Select Icon -->
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-chevron-down text-red-600 text-xs"></i>
                        </div>

                        <select id="typeFilter"
                                class="appearance-none w-44 pl-4 pr-10 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 bg-white
                           focus:border-red-500 focus:ring-2 focus:ring-red-100 focus:outline-none
                           transition-all duration-300 font-medium shadow-sm hover:shadow-md hover:border-red-400 cursor-pointer">
                            <option value="">All Types</option>
                            <option value="human">👤 Human</option>
                            <option value="pet">🐾 Pet</option>
                            <option value="valuables">💎 Valuables</option>
                        </select>
                    </div>
                </div>

                <!-- Clear Filters Button -->
                <button type="button"
                        id="clearFilters"
                        class="ml-auto inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-red-600 border border-red-600 rounded-lg
                   hover:bg-red-700 hover:border-red-700
                   focus:outline-none focus:ring-2 focus:ring-red-100
                   transition-all duration-300 shadow-sm hover:shadow-md">
                    <i class="fas fa-times-circle"></i>
                    Clear
                </button>
            </div>
        </div>

        <div class="overflow-x-auto rounded-lg shadow">
            <table id="qrTable" class="min-w-full border-collapse bg-white rounded-lg text-gray-700">
                <thead>
                    <tr class="bg-gray-200 text-gray-900">
                        <th class="py-3 px-4 text-left">ID</th>
                        <th class="py-3 px-4 text-left">QR Type</th>
                        <th class="py-3 px-4 text-left">UID</th>
                        <th class="py-3 px-4 text-left">PIN</th>
                        <th class="py-3 px-4 text-left">Batch No</th>
                        <th class="py-3 px-4 text-left">Code</th>
                        <th class="py-3 px-4 text-center">Code Image</th>
                        <th class="py-3 px-4 text-left">Status</th>
                        <th class="py-3 px-4 text-left">Details</th>
                        <th class="py-3 px-4 text-left">Actions</th>
                    </tr>
                </thead>

                <tbody id="qrTableBody">
                    @include('qr.qr-list-rows', ['qrcodes' => $qrcodes])
                </tbody>
            </table>

        </div>

        {{-- Pagination --}}
        <div class="mt-4" id="paginationLinks">
            @include('qr.qr-pagination', ['qrcodes' => $qrcodes])
        </div>
    </div>

    {{-- AJAX --}}
    <script>
        const typeFilter = document.getElementById('typeFilter');
        const uidInput = document.getElementById('uidSearch');
        const clearBtn = document.getElementById('clearFilters');
        const tableBody = document.getElementById('qrTableBody');
        const paginationLinks = document.getElementById('paginationLinks');

        // Unified AJAX Fetch
        function fetchQRCodes(url = null) {
            const type = typeFilter.value;
            const uid = uidInput.value.trim();
            const fetchUrl = url || `{{ route('qr.list.filter') }}?type=${encodeURIComponent(type)}&uid=${encodeURIComponent(uid)}`;

            fetch(fetchUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
                .then(res => res.json())
                .then(data => {
                    tableBody.innerHTML = data.rows;
                    paginationLinks.innerHTML = data.pagination;
                    window.history.pushState({}, '', fetchUrl);
                })
                .catch(err => console.error("Fetch error:", err));
        }

        // 🧭 Event Listeners
        typeFilter.addEventListener('change', () => fetchQRCodes());
        uidInput.addEventListener('keyup', () => fetchQRCodes());

        clearBtn.addEventListener('click', () => {
            uidInput.value = '';
            typeFilter.value = '';
            fetchQRCodes(); // Show all again
        });

        document.addEventListener('click', function(e) {
            const a = e.target.closest('#paginationLinks a');
            if (a) {
                e.preventDefault();
                fetchQRCodes(a.href);
            }
        });

        window.addEventListener('popstate', function() {
            fetchQRCodes(window.location.href);
        });
    </script>

@endsection
