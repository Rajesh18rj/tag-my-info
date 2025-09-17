<div id="PetFields" class="hidden space-y-4">
    <fieldset class="border-2 border-red-400 rounded-lg p-6 shadow-md bg-gray-50">
        <legend class="text-red-700 font-semibold mb-2 bg-red-100 px-3 py-1 rounded-md shadow-sm inline-block">
            Pet Info
        </legend>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="first_name_pet" class="block font-medium mb-1">Pet Name *</label>
                <input type="text" name="pet_first_name" id="first_name_pet" value="{{ old('pet_first_name', $profile->first_name) }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2" />
            </div>
            <div>
                <label for="breed_name" class="block font-medium mb-1">Breed</label>
                <input type="text" name="pet_breed_name" id="breed_name" value="{{ old('pet_breed_name', $profile->breed_name) }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2" />
            </div>
            <div>
                <label for="birth_date_pet" class="block font-medium mb-1">Birth Date</label>
                <input type="date" name="pet_birth_date" id="birth_date_pet" value="{{ old('pet_birth_date', $profile->birth_date) }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2" />
            </div>
            <div>
                <label for="gender_pet" class="block font-medium mb-1">Gender</label>
                <select name="pet_gender" id="gender_pet" class="w-full border border-gray-300 rounded-md px-3 py-2">
                    <option value="">-- Select --</option>
                    <option value="Male" {{ old('pet_gender', $profile->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('pet_gender', $profile->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                    <option value="Others" {{ old('pet_gender', $profile->gender) == 'Others' ? 'selected' : '' }}>Others</option>
                </select>
            </div>
            <div>
                <label for="hair_colour_pet" class="block font-medium mb-1">Hair Color</label>
                <input type="text" name="pet_hair_colour" id="hair_colour_pet" value="{{ old('pet_hair_colour', $profile->hair_colour) }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2" />
            </div>
            <div>
                <label for="eye_color_pet" class="block font-medium mb-1">Eye Color</label>
                <input type="text" name="pet_eye_color" id="eye_color_pet" value="{{ old('pet_eye_color', $profile->eye_color) }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2" />
            </div>
            <div>
                <label for="height_pet" class="block font-medium mb-1">Height</label>
                <input type="text" name="pet_height" id="height_pet" value="{{ old('pet_height', $profile->height) }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2" />
            </div>
            <div>
                <label for="weight_pet" class="block font-medium mb-1">Weight</label>
                <input type="text" name="pet_weight" id="weight_pet" value="{{ old('pet_weight', $profile->weight) }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2" />
            </div>
            <div class="md:col-span-2">
                <label for="identification_mark_pet" class="block font-medium mb-1">Identification Mark</label>
                <input type="text" name="pet_identification_mark" id="identification_mark_pet" value="{{ old('pet_identification_mark', $profile->identification_mark) }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2" />
            </div>
        </div>
    </fieldset>

    <fieldset class="border-2 border-red-400 rounded-lg p-6 shadow-md bg-gray-50">
        <legend class="text-red-700 font-semibold mb-2 bg-red-100 px-3 py-1 rounded-md shadow-sm inline-block">
            Address
        </legend>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="city_pet" class="block font-medium mb-1">City</label>
                <input type="text" name="pet_city" id="city_pet" value="{{ old('pet_city', $profile->city) }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2" />
            </div>
            <div>
                <label for="state_pet" class="block font-medium mb-1">State</label>
                <input type="text" name="pet_state" id="state_pet" value="{{ old('pet_state', $profile->state) }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2" />
            </div>
            <div>
                <label for="zip_code_pet" class="block font-medium mb-1">Zip Code</label>
                <input type="text" name="pet_zip_code" id="zip_code_pet" value="{{ old('pet_zip_code', $profile->zip_code) }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2" />
            </div>
        </div>
        <div class="mt-4">
            <label for="country_pet" class="block font-medium mb-1">Country</label>
            <input type="text" name="pet_country" id="country_pet" value="{{ old('pet_country', $profile->country) }}"
                   class="w-full border border-gray-300 rounded-md px-3 py-2" />
        </div>
    </fieldset>

    <fieldset class="border-2 border-red-400 rounded-lg p-6 shadow-md bg-gray-50">
        <legend class="text-red-700 font-semibold mb-2 bg-red-100 px-3 py-1 rounded-md shadow-sm inline-block">
            Notes
        </legend>
        <textarea name="pet_notes" rows="4"
                  class="w-full border border-gray-300 rounded-md px-3 py-2">{{ old('pet_notes', $profile->notes) }}</textarea>
    </fieldset>
</div>
