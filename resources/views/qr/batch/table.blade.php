<div class="overflow-x-auto">
    <table class="w-full">
        <thead class="bg-red-50 border-b-2 border-red-200">
        <tr>
            <th class="px-6 py-4 text-center text-sm font-bold text-gray-700 tracking-wider">
                <div class="flex flex-col items-center space-y-1">
                    <i class="fas fa-id-badge text-red-500 text-base"></i>
                    <span>Batch No</span>
                </div>
            </th>
            <th class="px-6 py-4 text-center text-sm font-bold text-gray-700 tracking-wider">
                <div class="flex flex-col items-center space-y-1">
                    <i class="fas fa-calendar text-red-500 text-base"></i>
                    <span>Created On</span>
                </div>
            </th>
            <th class="px-4 py-4 text-center text-sm font-bold text-gray-700 tracking-wider">
                <div class="flex flex-col items-center space-y-1">
                    <i class="fas fa-tag text-red-500 text-base"></i>
                    <span>Profile Type</span>
                </div>
            </th>
            <th class="px-6 py-4 text-center text-sm font-bold text-gray-700 tracking-wider">
                <div class="flex flex-col items-center space-y-1">
                    <i class="fas fa-calculator text-red-500 text-base"></i>
                    <span>Count</span>
                </div>
            </th>
            <th class="px-6 py-4 text-center text-sm font-bold text-gray-700 tracking-wider">
                <div class="flex flex-col items-center space-y-1">
                    <i class="fa-solid fa-download text-red-500 text-base"></i>
                    <span>Download</span>
                </div>
            </th>
            <th class="px-2 py-4 text-center text-sm font-bold text-gray-700 tracking-wider">
                <div class="flex flex-col items-center space-y-1">
                    <i class="fas fa-tasks text-red-500 text-base"></i>
                    <span>Status</span>
                </div>
            </th>
        </tr>
        </thead>

        <tbody class="divide-y divide-gray-200">
        @forelse($batches as $batch)
            <tr class="hover:bg-gray-50 transition-colors duration-200">
                <td class="px-2  py-4 whitespace-nowrap text-center">
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

                <td class="px-4 py-4 whitespace-nowrap text-center">
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

                <td class="px-0 py-4 whitespace-nowrap">
                    <div class="flex flex-col items-center space-y-2">
                        @php
                            $statusColors = [
                                'pending'  => 'bg-yellow-100 text-yellow-800',
                                'sending'  => 'bg-blue-100 text-blue-800',
                                'received' => 'bg-purple-100 text-purple-800',
                                'verified' => 'bg-green-100 text-green-800',
                            ];
                            $statusLabels = [
                                'pending'  => 'Pending for Print',
                                'sending'  => 'Sending for Print',
                                'received' => 'Received from Print',
                                'verified' => 'Verified & Completed',
                            ];
                            $statusIcons = [
                                'pending'  => 'fas fa-clock',
                                'sending'  => 'fas fa-paper-plane',
                                'received' => 'fas fa-inbox',
                                'verified' => 'fas fa-check-circle',
                            ];
                        @endphp

                            <!-- Status Badge -->
                        <span class="status-text inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$batch->status] ?? 'bg-gray-100 text-gray-800' }}">
                            <i class="{{ $statusIcons[$batch->status] ?? 'fas fa-question-circle' }} text-xs mr-2"></i>
                            {{ $statusLabels[$batch->status] ?? ucfirst($batch->status) }}
                        </span>

                        <!-- Edit Button -->
                        <button class="edit-status-btn inline-flex items-center bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-medium px-2 py-1 rounded-md border border-gray-300 transition-colors duration-200"
                                data-id="{{ $batch->id }}"
                                data-status="{{ $batch->status }}">
                            <i class="fas fa-edit text-xs mr-1"></i>
                            Edit
                        </button>
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

<script>
    document.querySelectorAll('.edit-status-btn').forEach(button => {
        button.addEventListener('click', function() {
            const batchId = this.dataset.id;
            const currentStatus = this.dataset.status;

            Swal.fire({
                title: 'Edit Batch Status',
                input: 'select',
                inputOptions: {
                    'pending': 'Pending for Print',
                    'sending': 'Sending for Print',
                    'received': 'Received from Print',
                    'verified': 'Verified & Completed'
                },
                inputValue: currentStatus,
                showCancelButton: true,
                confirmButtonText: 'Update Status',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#6b7280',
                customClass: {
                    popup: 'rounded-xl shadow-2xl',
                    title: 'text-gray-800 font-semibold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post(`/qr-batches/${batchId}/status`, {
                        status: result.value,
                        _token: '{{ csrf_token() }}'
                    })
                        .then(response => {
                            if(response.data.success){
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Status Updated!',
                                    text: 'Status changed to ' + result.value,
                                    timer: 1500,
                                    showConfirmButton: false,
                                    customClass: {
                                        popup: 'rounded-xl shadow-2xl'
                                    }
                                });

                                // Update button data-status
                                button.dataset.status = result.value;

                                // Update badge with proper icon, text and classes
                                const badge = button.closest('td').querySelector('.status-text');

                                // Define status mapping with all properties
                                const statusMap = {
                                    'pending': {
                                        text: 'Pending for Print',
                                        class: 'status-text inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800',
                                        icon: 'fas fa-clock'
                                    },
                                    'sending': {
                                        text: 'Sending for Print',
                                        class: 'status-text inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800',
                                        icon: 'fas fa-paper-plane'
                                    },
                                    'received': {
                                        text: 'Received from Print',
                                        class: 'status-text inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800',
                                        icon: 'fas fa-inbox'
                                    },
                                    'verified': {
                                        text: 'Verified & Completed',
                                        class: 'status-text inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800',
                                        icon: 'fas fa-check-circle'
                                    }
                                };

                                const statusInfo = statusMap[result.value];
                                if (statusInfo) {
                                    // Update the entire badge content and classes
                                    badge.className = statusInfo.class;
                                    badge.innerHTML = `<i class="${statusInfo.icon} text-xs mr-2"></i>${statusInfo.text}`;
                                }
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Unable to update status.',
                                customClass: {
                                    popup: 'rounded-xl shadow-2xl'
                                }
                            });
                        });
                }
            });
        });
    });
</script>
