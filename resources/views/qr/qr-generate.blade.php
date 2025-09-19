@extends('layouts.new-layout')

@section('content')
    <div class="max-w-md mx-auto bg-white p-6 rounded-xl shadow">
        <h2 class="text-xl font-bold mb-4">Generate QR Codes</h2>

        <form action="{{ route('qr.generate') }}" method="POST">
            @csrf

            <!-- Count Input -->
            <div class="mb-4">
                <label for="count" class="block text-gray-700 font-medium mb-2">
                    How many QR codes to generate?
                </label>
                <input type="number" name="count" id="count"
                       value="10" min="1" max="1000"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring">
            </div>

            <!-- Profile Type Dropdown -->
            <div class="mb-4">
                <label for="profile_type" class="block text-gray-700 font-medium mb-2">
                    Profile Type
                </label>
                <select name="profile_type" id="profile_type"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring">
                    <option value="Human">Human</option>
                    <option value="Pet">Pet</option>
                    <option value="Valuables">Valuables</option>
                </select>
            </div>

            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold">
                Generate
            </button>
        </form>
    </div>

{{--    @include('qr.qr-generate-list')--}}
@endsection
