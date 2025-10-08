@extends('layouts.new-layout')

@section('content')
    <!-- Main dashboard area -->
    <main class="flex-1 p-2 min-h-screen mt-8">
        <h1 class="text-2xl font-semibold text-red-700 mb-8 inline-flex items-center space-x-3 bg-red-50 rounded-lg px-6 py-3 shadow-lg max-w-max">
            <span>Welcome,</span>
            <span class="capitalize text-red-900 font-bold tracking-wide">{!! ucfirst(auth()->user()->name ?? 'Guest') !!}</span>
                <span class="text-red-600 text-2xl animate-bounce">
                    <i class="fa-regular fa-face-smile"></i>
                </span>
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white border border-red-100 p-8 rounded-xl shadow hover:shadow-lg transition-shadow text-red-600 font-semibold">
                Have a Great Day!
            </div>
            <div class="bg-white border border-red-100 p-8 rounded-xl shadow hover:shadow-lg transition-shadow text-red-600 font-semibold">
                Stay Happy!
            </div>
        </div>

    </main>
@endsection
