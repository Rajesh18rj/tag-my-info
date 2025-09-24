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
            <th class="px-6 py-4 text-center text-sm font-bold text-gray-700 tracking-wider">
                <i class="fa-solid fa-download text-red-500 mr-2"></i>
                Download
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
                            'Valuables' => ['icon' => '🛍️', 'color' => 'yellow'],
                        ];
                        $config = $typeConfig[$profileType] ?? ['icon' => '❓', 'color' => 'gray'];
                    @endphp
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-{{ $config['color'] }}-100 text-{{ $config['color'] }}-800">
                                        {{ $config['icon'] }} {{ $profileType }}
                    </span>
                </td>

                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-red-50 rounded-full flex items-center justify-center">
                            <i class="fas fa-qrcode text-red-500 text-sm"></i>
                        </div>
                        <span class="text-gray-700 font-medium">
                                        {{ $batch->count }}
                        </span>
                    </div>
                </td>

                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-center space-x-2">
                        <a href="{{ route('qr.qr-batches.download', $batch) }}"
                           class="inline-flex items-center bg-teal-500 hover:bg-teal-600 text-white text-sm px-3 py-1 rounded-lg transition-colors">
                            <i class="fas fa-download text-xs mr-1"></i>
                            ZIP
                        </a>
                    </div>
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
