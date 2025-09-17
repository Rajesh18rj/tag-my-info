<div id="ownerModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg w-1/3">
        <h2 class="text-lg font-bold mb-4">Add Pet Owner</h2>
        <input type="text" name="owners[]" placeholder="Owner Name" class="w-full border p-2 mb-4">
        <div class="flex justify-end gap-2">
            <button type="button" onclick="document.getElementById('ownerModal').classList.add('hidden')" class="px-4 py-2 bg-gray-400 text-white rounded">Cancel</button>
            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded">Save</button>
        </div>
    </div>
</div>
