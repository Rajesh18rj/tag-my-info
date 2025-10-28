@extends('layouts.new-layout')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-red-50 to-red-100 rounded-xl p-6 mb-8 border border-red-200 shadow-lg">
            <h1 class="text-xl font-bold text-gray-800 mb-2 flex items-center">
                <i class="fas fa-qrcode text-red-600 mr-3"></i>
                QR Batches Management
            </h1>
            <p class="text-gray-600">Generate and manage QR code batches for different profile types</p>
        </div>

        <!-- Form Section -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-plus-circle text-red-600 mr-2"></i>
                Create New Batch
            </h2>

            @include('qr.batch.form')
        </div>

        <!-- Card section-->
        <div>
            @include('qr.batch.card-section')
        </div>

        <!-- Table Section -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-table text-red-600 mr-2"></i>
                    Generated Batches
                </h2>
            </div>

            @include('qr.batch.table')
        </div>

        <!-- Pagination -->
        @if($batches->hasPages())
            <div class="mt-8 bg-white rounded-xl shadow-lg border border-gray-200 p-6">
                <div class="flex justify-end">
                    {{ $batches->links('pagination::tailwind') }}
                </div>
            </div>
        @endif
    </div>

    <style>
        /* Custom pagination styling */
        .pagination {
            @apply flex space-x-1;
        }
        .pagination .page-link {
            @apply px-3 py-2 text-sm leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 rounded-md transition-colors;
        }
        .pagination .page-item.active .page-link {
            @apply bg-red-600 text-white border-red-600;
        }
        .pagination .page-item.disabled .page-link {
            @apply text-gray-300 cursor-not-allowed;
        }
    </style>
@endsection
