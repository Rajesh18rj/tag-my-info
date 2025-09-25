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
                <option value="Valuables">🛍️ Valuables</option>
            </select>
        </div>
    </div>

    <button type="button" id="generateBatchBtn"
            class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold px-4 py-3 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
        <i class="fas fa-wand-magic-sparkles mr-2"></i>
        Generate Batch
    </button>

</form>

<script>
    document.getElementById('generateBatchBtn').addEventListener('click', function() {
        const count = document.querySelector('input[name="count"]').value;
        const profileType = document.querySelector('select[name="profile_type"]').value;

        if (!count || !profileType) {
            Swal.fire({
                title: 'Missing Information',
                text: 'Please complete all fields first.',
                icon: 'warning',
                confirmButtonColor: '#f59e0b',
                customClass: {
                    popup: 'rounded-xl shadow-2xl',
                    title: 'text-gray-800 font-semibold'
                }
            });
            return;
        }

        // Check if count is greater than 100
        if (count > 100) {
            Swal.fire({
                title: 'Invalid Count',
                text: 'You cannot generate more than 100 QR codes at once.',
                icon: 'error',
                confirmButtonColor: '#ef4444',
                customClass: {
                    popup: 'rounded-xl shadow-2xl border-t-4 border-red-500',
                    title: 'text-lg font-bold text-gray-800',
                    content: 'text-gray-600'
                }
            });
            return;
        }

        Swal.fire({
            title: 'Generate QR Batch',
            text: `Create ${count} QR codes for ${profileType} profiles?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Generate',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-xl shadow-2xl border-t-4 border-blue-500',
                title: 'text-lg font-bold text-gray-800',
                content: 'text-gray-600',
                confirmButton: 'font-semibold rounded-lg shadow-md',
                cancelButton: 'font-semibold rounded-lg shadow-md'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Processing...',
                    text: 'Generating your QR batch',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    customClass: {
                        popup: 'rounded-xl shadow-2xl'
                    },
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                this.closest('form').submit();
            }
        });
    });
</script>


