@if($profile->id)
    <div class="mb-6 max-w-sm flex items-center gap-6">
        <img
            src="{{ $profile->profile_image
                   ? asset('storage/' . $profile->profile_image)
                   : asset('empty.jpg') }}"
            alt="Profile Image"
            class="w-24 h-24 object-cover rounded-full border border-gray-300 shadow-sm"
            loading="lazy"
        >

        <div class="flex-grow">
            <label for="profile_image" class="block mb-2 font-semibold text-gray-700 text-lg">
                Profile Image
            </label>
            <input
                type="file"
                name="profile_image"
                id="profile_image"
                accept="image/*"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-700
focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
            >

            @error('profile_image')
            <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
@endif
