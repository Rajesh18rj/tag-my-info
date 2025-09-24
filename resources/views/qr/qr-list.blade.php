@extends('layouts.new-layout')

@section('content')
    <div class="max-w-7xl mx-auto py-8 px-4">
        <div class="flex items-center mb-8 border-b pb-4">
            <span class="bg-red-100 text-red-600 rounded-xl p-3 mr-4 shadow-sm">
                <i class="fa fa-qrcode text-2xl"></i>
            </span>
            <h2 class="text-3xl font-bold text-gray-800 tracking-wide">
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
{{--                <a href="{{ route('qr.showGenerateForm') }}"--}}
                <a href="{{ route('qr-batches.index') }}"

                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold shadow flex items-center gap-2">
                    <i class="fas fa-cog"></i> Generate QR Codes
                </a>
            </div>

            <!--Filter--->
            <div class="mb-4 flex items-center gap-4">
                <label for="typeFilter" class="font-semibold">Filter by Type:</label>
                <select id="typeFilter"
                        class="border border-gray-300 rounded px-8 py-2 pl-2 text-gray-700 focus:border-red-600 focus:ring-2 focus:ring-red-600 focus:outline-none bg-white font-semibold">
                    <option value="" class="bg-white hover:bg-red-600 hover:text-white">All</option>
                    <option value="Human" class="bg-white hover:bg-red-600 hover:text-white">Human</option>
                    <option value="Pet" class="bg-white hover:bg-red-600 hover:text-white">Pet</option>
                    <option value="Valuables" class="bg-white hover:bg-red-600 hover:text-white">Valuables</option>
                </select>
            </div>

        </div>

        <div class="overflow-x-auto rounded-lg shadow">
            <table class="min-w-full border-collapse bg-white rounded-lg text-gray-700">
                <thead>
                    <tr class="bg-gray-200 text-gray-900">
                        <th class="py-3 px-4 text-left">ID</th>
                        <th class="py-3 px-4 text-left">QR Type</th>
                        <th class="py-3 px-4 text-left">UID</th>
                        <th class="py-3 px-4 text-left">PIN</th>
                        <th class="py-3 px-4 text-left">Code</th>
                        <th class="py-3 px-4 text-left">Code Image</th>
                        <th class="py-3 px-4 text-left">Status</th>
                        <th class="py-3 px-4 text-left">Details</th>
                        <th class="py-3 px-4 text-center">Actions</th>
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
        const tableBody = document.getElementById('qrTableBody');
        const paginationLinks = document.getElementById('paginationLinks');

        function fetchQRCodes(url = null) {
            const type = typeFilter.value;
            const fetchUrl = url || `{{ route('qr.list.filter') }}?type=${encodeURIComponent(type)}`;

            fetch(fetchUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
                .then(res => res.json()) // now safe because backend always sends JSON
                .then(data => {
                    tableBody.innerHTML = data.rows;
                    paginationLinks.innerHTML = data.pagination;

                    // Update browser URL
                    window.history.pushState({}, '', fetchUrl);
                })
                .catch(err => console.error("Fetch error:", err));
        }

        // On filter change
        typeFilter.addEventListener('change', () => {
            fetchQRCodes();
        });

        // On pagination click
        document.addEventListener('click', function(e) {
            const a = e.target.closest('#paginationLinks a');
            if (a) {
                e.preventDefault();
                fetchQRCodes(a.href);
            }
        });

        // Back/forward button support
        window.addEventListener('popstate', function() {
            fetchQRCodes(window.location.href);
        });
    </script>


@endsection
