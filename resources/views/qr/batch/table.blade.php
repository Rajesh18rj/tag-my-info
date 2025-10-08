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

            const statusMap = {
                'pending': { text: 'Pending for Print', class: 'bg-yellow-100 text-yellow-800', icon: 'fas fa-clock' },
                'sending': { text: 'Sending for Print', class: 'bg-blue-100 text-blue-800', icon: 'fas fa-paper-plane' },
                'received': { text: 'Received from Print', class: 'bg-purple-100 text-purple-800', icon: 'fas fa-inbox' },
                'verified': { text: 'Verified & Completed', class: 'bg-green-100 text-green-800', icon: 'fas fa-check-circle' }
            };

            // Remove existing modal
            const existingModal = document.querySelector('.status-modal-overlay');
            if (existingModal) existingModal.remove();

            // Overlay
            const overlay = document.createElement('div');
            overlay.className = 'status-modal-overlay fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 opacity-0 transition-opacity duration-300';
            document.body.appendChild(overlay);

            // Modal container
            const modal = document.createElement('div');
            modal.className = 'bg-white rounded-xl shadow-2xl p-6 w-80 transform transition-transform duration-300 scale-90';
            overlay.appendChild(modal);

            // Modal title
            const title = document.createElement('h3');
            title.textContent = 'Update Batch Status';
            title.className = 'text-gray-800 font-semibold text-lg mb-4';
            modal.appendChild(title);

            // Dropdown select
            const select = document.createElement('select');
            select.className = 'w-full border border-gray-300 rounded px-3 py-2 mb-4';
            Object.keys(statusMap).forEach(key => {
                const option = document.createElement('option');
                option.value = key;
                option.textContent = statusMap[key].text;
                if (key === currentStatus) option.selected = true;
                select.appendChild(option);
            });
            modal.appendChild(select);

            // Buttons container
            const btnContainer = document.createElement('div');
            btnContainer.className = 'flex justify-end space-x-2';
            modal.appendChild(btnContainer);

            // Cancel button
            const cancelBtn = document.createElement('button');
            cancelBtn.textContent = 'Cancel';
            cancelBtn.className = 'px-3 py-1 rounded bg-gray-200 hover:bg-gray-300 text-sm';
            cancelBtn.onclick = () => {
                overlay.classList.remove('opacity-100');
                overlay.classList.add('opacity-0');
                modal.classList.remove('scale-100');
                modal.classList.add('scale-90');
                setTimeout(() => overlay.remove(), 300);
            };
            btnContainer.appendChild(cancelBtn);

            // Update button
            const updateBtn = document.createElement('button');
            updateBtn.textContent = 'Update';
            updateBtn.className = 'px-3 py-1 rounded bg-blue-500 hover:bg-blue-600 text-white text-sm';
            updateBtn.onclick = () => {
                const newStatus = select.value;
                fetch(`/qr-batches/${batchId}/status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ status: newStatus })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            // Update badge
                            const badge = button.closest('td').querySelector('.status-text');
                            const info = statusMap[newStatus];
                            badge.className = `status-text inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold ${info.class}`;
                            badge.innerHTML = `<i class="${info.icon} text-xs mr-2"></i>${info.text}`;
                            button.dataset.status = newStatus;

                            // Close modal
                            overlay.classList.remove('opacity-100');
                            overlay.classList.add('opacity-0');
                            modal.classList.remove('scale-100');
                            modal.classList.add('scale-90');
                            setTimeout(() => overlay.remove(), 300);

                            // Show success toast
                            const toast = document.createElement('div');
                            toast.className = 'fixed top-5 right-5 bg-green-500 text-white px-4 py-2 rounded shadow-lg opacity-0 transform translate-y-[-20px] transition-all duration-300 z-50';
                            toast.textContent = `Status Updated to "${info.text}"`;
                            document.body.appendChild(toast);
                            setTimeout(() => {
                                toast.classList.add('opacity-100');
                                toast.classList.remove('translate-y-[-20px]');
                            }, 10);

                            setTimeout(() => {
                                toast.classList.remove('opacity-100');
                                toast.classList.add('translate-y-[-20px]');
                                setTimeout(() => toast.remove(), 300);
                            }, 1800);

                        } else {
                            alert('Unable to update status.');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Error updating status.');
                    });
            };
            btnContainer.appendChild(updateBtn);

            // Animate modal fade-in
            setTimeout(() => {
                overlay.classList.add('opacity-100');
                modal.classList.remove('scale-90');
                modal.classList.add('scale-100');
            }, 10);

            // Close modal if clicked outside
            overlay.addEventListener('click', e => {
                if (e.target === overlay) {
                    overlay.classList.remove('opacity-100');
                    overlay.classList.add('opacity-0');
                    modal.classList.remove('scale-100');
                    modal.classList.add('scale-90');
                    setTimeout(() => overlay.remove(), 300);
                }
            });
        });
    });
</script>
