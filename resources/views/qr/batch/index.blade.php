@extends('layouts.new-layout')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-red-50 to-red-100 rounded-xl p-6 mb-8 border border-red-200 shadow-lg">
            <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center">
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

            <form action="{{ route('qr.qr-batches.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Count Input -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-hashtag text-red-500 mr-1"></i>
                            QR Code Count
                        </label>
                        <input type="number"
                               name="count"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                               min="1"
                               max="100"
                               placeholder="Enter count (1-100)"
                               required>
                    </div>

                    <!-- Profile Type Select -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-user-tag text-red-500 mr-1"></i>
                            Profile Type
                        </label>
                        <select name="profile_type"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                                required>
                            <option value="">Select profile type</option>
                            <option value="Human">👤 Human</option>
                            <option value="Pet">🐾 Pet</option>
                            <option value="Valuables">💎 Valuables</option>
                        </select>
                    </div>
                </div>

                <button type="submit"
                        class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold px-8 py-3 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                    <i class="fas fa-magic mr-2"></i>
                    Generate Batch
                </button>
            </form>
        </div>

        <!-- Table Section -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-table text-red-600 mr-2"></i>
                    Generated Batches
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-red-50 border-b-2 border-red-200">
                    <tr>
                        <th class="px-6 py-4 text-center text-sm font-bold text-gray-700  tracking-wider">
                            <i class="fas fa-id-badge text-red-500 mr-2"></i>
                            Batch No
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 tracking-wider">
                            <i class="fas fa-calendar text-red-500 mr-2"></i>
                            Created On
                        </th>
                        <th class="px-6 py-4 text-center text-sm font-bold text-gray-700  tracking-wider">
                            <i class="fas fa-tag text-red-500 mr-2"></i>
                            Profile Type
                        </th>
                        <th class="px-6 py-4 text-center text-sm font-bold text-gray-700  tracking-wider">
                            <i class="fas fa-calculator text-red-500 mr-2"></i>
                            Count
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">
                            <i class="fas fa-cogs text-red-500 mr-2"></i>
                            Actions
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    @forelse($batches as $batch)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class=" rounded-full p-2 mr-3">
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">#{{ $batch->id }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <i class="fas fa-clock text-gray-400 mr-1"></i>
                                {{ $batch->created_at->format('M d, Y \a\t h:i A') }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @php
                                    $profileType = optional($batch->qrcodes->first())->profile_type ?? 'N/A';
                                    $typeConfig = [
                                        'Human' => ['icon' => '👤', 'color' => 'green'],
                                        'Pet' => ['icon' => '🐾', 'color' => 'purple'],
                                        'Valuables' => ['icon' => '💎', 'color' => 'yellow'],
                                    ];
                                    $config = $typeConfig[$profileType] ?? ['icon' => '❓', 'color' => 'gray'];
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-{{ $config['color'] }}-100 text-{{ $config['color'] }}-800">
                                        {{ $config['icon'] }} {{ $profileType }}
                                    </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center justify-start space-x-2">
                                    <i class="fas fa-qrcode text-red-600 text-lg bg-red-50 rounded-full p-2"></i>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-red-50 text-blue-800 min-w-[60px] justify-center">
                                        {{ $batch->count }}
                                    </span>
                                </div>
                            </td>


                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('qr.qr-batches.download', $batch) }}"
                                   class="inline-flex items-center bg-gradient-to-r from-teal-600 to-teal-700 hover:from-teal-700 hover:to-teal-800 text-white font-semibold px-4 py-2 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-md">
                                    <i class="fas fa-download mr-2"></i>
                                    Download ZIP
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-inbox text-gray-300 text-4xl mb-4"></i>
                                    <p class="text-gray-500 text-lg font-medium">No batches found</p>
                                    <p class="text-gray-400 text-sm mt-1">Create your first QR batch using the form above</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
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
