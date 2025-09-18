@extends('layouts.new-layout')

@section('content')
    <div class="max-w-lg mx-auto py-8 px-6 shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-red-600">
            Mapping Data to QR:
{{--            <span class="text-gray-700">{{ $qr->code }}</span>--}}
        </h2>

        @if(session('error'))
            <div class="mb-4 p-3 rounded bg-red-100 text-red-700 font-semibold border border-red-300">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-3 rounded bg-red-50 text-red-700 border border-red-300">
                <ul class="pl-5 list-disc">
                    @foreach($errors->all() as $error)
                        <li class="mb-1">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('qr.store') }}" method="POST" class="space-y-5 bg-white p-6 rounded-lg shadow">
            @csrf
            <input type="hidden" name="qr_code_id" value="{{ $qr->id }}">

            <div>
                <label for="name" class="block mb-1 font-semibold text-gray-800">Name   <span class="text-gray-400">(Optional)</span></label>
                <input type="text" name="name" id="name" required
                       class="w-full py-2 px-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-red-500">
            </div>


            <div>
                <label for="uid" class="block mb-1 font-semibold text-gray-800">UID:</label>
                <input type="text" name="uid" id="uid" required
                       class="w-full py-2 px-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-red-500">
            </div>

            <div>
                <label for="pin" class="block mb-1 font-semibold text-gray-800">PIN:</label>
                <input type="text" name="pin" id="pin" required
                       class="w-full py-2 px-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-red-500">
            </div>

            <button type="submit"
                    class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded font-semibold shadow transition">
                Save
            </button>
        </form>
    </div>
@endsection
