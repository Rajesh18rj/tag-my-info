@extends('layouts.new-layout')

@section('content')
    <div class="max-w-7xl mx-auto py-8 px-4">
        <h2 class="text-2xl font-semibold mb-6 text-red-600">All QR Codes</h2>

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

{{--        <a href="{{ route('qr.form') }}"--}}
{{--           class="inline-block px-5 py-2 mb-6 rounded bg-red-600 text-white hover:bg-red-700 transition font-medium shadow">--}}
{{--            Map Data to Free QR--}}
{{--        </a>--}}

        <div class="overflow-x-auto rounded shadow">
            <table class="w-full border-collapse bg-white rounded-lg overflow-hidden text-gray-700">
                <thead>
                <tr class="bg-gray-200 text-gray-900">
                    <th class="py-3 px-4 text-left">ID</th>
                    <th class="py-3 px-4 text-left">UID</th>
                    <th class="py-3 px-4 text-left">PIN</th>
                    <th class="py-3 px-4 text-left">Code</th>
                    <th class="py-3 px-4 text-left">Code Image</th>
                    <th class="py-3 px-4 text-left">Status</th>
                    <th class="py-3 px-4 text-left">Details</th>
                    <th class="py-3 px-4 text-left">Download</th>
                </tr>
                </thead>
                <tbody>
                @foreach($qrcodes as $qr)
                    <tr class="border-b hover:bg-red-50 transition">
                        <td class="py-2 px-4">{{ $qr->id }}</td>
                        <td class="py-2 px-4 font-mono text-sm">{{ $qr->uid }}</td>
                        <td class="py-2 px-4 font-mono text-sm">{{ $qr->pin }}</td>
                        <td class="py-2 px-4">{{ $qr->code }}</td>
                        <td class="py-2 px-4">
                            <div class="flex justify-center items-center">
                                {!! QrCode::size(90)->generate(url('/qr-details/' . $qr->id)) !!}
                            </div>
                        </td>
                        <td class="py-2 px-4">
                            @if($qr->status)
                                <span class="inline-block px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">Used</span>
                            @else
                                <span class="inline-block px-3 py-1 rounded-full bg-gray-200 text-gray-700 text-xs font-semibold">Free</span>
                            @endif
                        </td>
                        <td class="py-2 px-4">
                            @if($qr->detail)
                                <span title="{{ $qr->detail->email }}">
                                    {{ $qr->detail->name }} <span class="text-gray-400">({{ $qr->detail->email }})</span>
                                </span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="py-2 px-4">
                            <a href="{{ route('qr.download', $qr->id) }}"
                               class="text-red-600 hover:underline hover:text-red-800 font-medium">
                                Download
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
