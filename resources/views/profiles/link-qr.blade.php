@extends('layouts.new-layout')

@section('title', 'Link QR to Profile')

@section('content')
    <h1 class="text-2xl font-bold text-red-600 mb-6">
        Link QR to Profile: {{ $profile->name ?? 'Profile #'.$profile->id }}
    </h1>

    @if(session('error'))
        <p class="text-red-600 mb-4">{{ session('error') }}</p>
    @endif
    @if(session('success'))
        <p class="text-green-600 mb-4">{{ session('success') }}</p>
    @endif


    <form method="POST" action="{{ route('profiles.link-qr.store', $profile->id) }}" class="space-y-4 max-w-md">
        @csrf

        <div>
            <label for="uid" class="block font-semibold">UID</label>
            <input type="text" name="uid" id="uid"
                   class="w-full border rounded p-2"
                   required>
        </div>

        <div>
            <label for="pin" class="block font-semibold">PIN</label>
            <input type="text" name="pin" id="pin"
                   class="w-full border rounded p-2"
                   required>
        </div>

        <div>
            <label for="name" class="block font-semibold">Label (optional)</label>
            <input type="text" name="name" id="name"
                   class="w-full border rounded p-2"
                   placeholder="e.g. Pet Collar QR">
        </div>

        <button type="submit"
                class="bg-red-600 px-6 py-2 rounded text-white font-semibold hover:bg-red-700">
            Link QR
        </button>
    </form>

    <hr class="my-6">

    <h2 class="text-xl font-semibold mb-2">Already Linked QRs</h2>
    <ul class="list-disc ml-6">
        @foreach($profile->qrDetails as $detail)
            <li>
                {{ $detail->qrCode->uid }} ({{ $detail->qrCode->pin }})
                @if($detail->name) - {{ $detail->name }} @endif
            </li>
        @endforeach
    </ul>
@endsection
