<fieldset class="ml-1 relative border-2 border-red-400 rounded-lg p-6 shadow-md bg-gray-50 max-w-3xl mx-auto">
<legend class="text-red-700 font-semibold mb-2 bg-red-100 px-3 py-1 rounded-md shadow-sm inline-block">
        Allergies
    </legend>

    <button type="button"
            id="openAddModal"
            class="absolute -top-10 right-3 bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-all shadow"
    >
        + Add Allergy
    </button>

    @if($profile->allergies->count())
        <!-- Headers -->
        <div class="hidden sm:flex justify-between font-bold text-red-700 border-b-2 border-red-200 pb-2 mb-3 px-4">
            <span class="flex-1">Allergic Name</span>
            <span class="flex-1">Notes</span>
            <span class="w-24 text-center">Actions</span>
        </div>

        <!-- Allergy Items -->
        <div class="space-y-3">
            @foreach($profile->allergies as $allergy)
                <li class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-4 rounded-lg border border-red-200 bg-white shadow hover:shadow-md transition">

                    <!-- Name Column -->
                    <div class="flex-1">
                        <p class="text-red-700 font-bold text-lg">{{ $allergy->allergic_name }}</p>
                    </div>

                    <!-- Notes Column -->
                    <div class="flex-1 mt-2 sm:mt-0">
                        @if($allergy->notes)
                            <p class="text-gray-600 text-sm">{{ $allergy->notes }}</p>
                        @else
                            <p class="text-gray-400 text-sm italic">No notes</p>
                        @endif
                    </div>

                    <!-- Actions Column -->
                    <div class="flex gap-4 w-24 justify-center items-center mt-2 sm:mt-0">
                        <!-- Edit Icon -->
                        <button type="button"
                                class="editBtn text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition"
                                data-id="{{ $allergy->id }}"
                                data-name="{{ $allergy->allergic_name }}"
                                data-notes="{{ $allergy->notes }}"
                                title="Edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>

                        <!-- Delete Icon -->
                        <form method="POST" action="{{ route('profiles.allergies.destroy', [$profile->id, $allergy->id]) }}"
                              onsubmit="return confirm('Are you sure you want to delete this allergy?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition"
                                    title="Delete">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>

                </li>
            @endforeach
        </div>
    @else
        <p class="text-gray-500 italic">No allergies recorded.</p>
    @endif


    <!-- Add Allergy Modal -->
    <div id="addModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-xl p-6 w-full max-w-md shadow-lg relative">
            <h2 class="text-xl font-bold text-red-700 mb-4">Add Allergy</h2>
            <form method="POST" action="{{ route('profiles.allergies.store', $profile->id) }}">
                @csrf
                <input type="hidden" name="profile_id" value="{{ $profile->id }}">
                <div class="mb-4">
                    <label class="block font-medium text-black mb-1">Allergic Name</label>
                    <input type="text" name="allergic_name" class="w-full border-2 border-red-300 px-3 py-2 rounded-lg focus:ring-2 focus:ring-red-400" required>
                </div>
                <div class="mb-4">
                    <label class="block font-medium text-black mb-1">Notes</label>
                    <textarea name="notes" class="w-full border-2 border-red-300 px-3 py-2 rounded-lg focus:ring-2 focus:ring-red-400"></textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" id="closeAddModal" class="px-4 py-2 rounded-lg border border-red-300 hover:bg-red-50 transition">Cancel</button>
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Allergy Modal -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-xl p-6 w-full max-w-md shadow-lg relative">
            <h2 class="text-xl font-bold text-red-700 mb-4">Edit Allergy</h2>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block font-medium text-black mb-1">Allergic Name</label>
                    <input type="text" id="editName" name="allergic_name" class="w-full border-2 border-red-300 px-3 py-2 rounded-lg focus:ring-2 focus:ring-red-400" required>
                </div>
                <div class="mb-4">
                    <label class="block font-medium text-black mb-1">Notes</label>
                    <textarea id="editNotes" name="notes" class="w-full border-2 border-red-300 px-3 py-2 rounded-lg focus:ring-2 focus:ring-red-400"></textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" id="closeEditModal" class="px-4 py-2 rounded-lg border border-red-300 hover:bg-red-50 transition">Cancel</button>
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">Update</button>
                </div>
            </form>
        </div>
    </div>
</fieldset>

<script>
    // Helper to close modal if click outside
    function setupModal(modal, closeBtn) {
        closeBtn.addEventListener('click', () => modal.classList.add('hidden'));
        modal.addEventListener('click', (e) => {
            if (e.target === modal) modal.classList.add('hidden');
        });
    }

    // Add Modal
    const addModal = document.getElementById('addModal');
    setupModal(addModal, document.getElementById('closeAddModal'));
    document.getElementById('openAddModal').addEventListener('click', () => addModal.classList.remove('hidden'));

    // Edit Modal
    const editModal = document.getElementById('editModal');
    const editForm = document.getElementById('editForm');
    const editName = document.getElementById('editName');
    const editNotes = document.getElementById('editNotes');

    setupModal(editModal, document.getElementById('closeEditModal'));

    document.querySelectorAll('.editBtn').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const name = btn.dataset.name;
            const notes = btn.dataset.notes;

            editName.value = name;
            editNotes.value = notes;
            editForm.action = `/profiles/{{ $profile->id }}/allergies/${id}`;

            editModal.classList.remove('hidden');
        });
    });
</script>
