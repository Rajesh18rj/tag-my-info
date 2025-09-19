<div id="ValuablesFields" class="hidden space-y-4">
    <fieldset class="border-2 border-red-400 rounded-lg p-6 shadow-md bg-gray-50">
        <legend class="text-red-700 font-semibold mb-2 bg-red-100 px-3 py-1 rounded-md shadow-sm inline-block">
            Valuables Info
        </legend>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="first_name_valuables" class="block font-medium mb-1">Name *</label>
                <input type="text" name="valuables_first_name" id="first_name_valuables" value="{{ old('valuables_first_name', $profile->first_name) }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2" />
                @error('first_name')<p class="text-red-600 mt-1 text-sm">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="personal_number_valuables" class="block font-medium mb-1">Personal Number</label>
                <input type="text" name="valuables_personal_number" id="personal_number_valuables" value="{{ old('valuables_personal_number', $profile->personal_number) }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2" />
            </div>
            <div>
                <label for="alternate_number_valuables" class="block font-medium mb-1">Alt Number</label>
                <input type="text" name="valuables_alternate_number" id="alternate_number_valuables" value="{{ old('valuables_alternate_number', $profile->alternate_number) }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2" />
            </div>
            <div>
                <label for="email_valuables" class="block font-medium mb-1">Email</label>
                <input type="email" name="valuables_email" id="email_valuables" value="{{ old('valuables_email', $profile->email) }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2" />
            </div>
        </div>
        <fieldset class="mt-4">
            <legend class="text-red-600 font-semibold mb-2">Notes</legend>
            <textarea name="valuables_notes" rows="4"
                      class="w-full border border-gray-300 rounded-md px-3 py-2">{{ old('valuables_notes', $profile->notes) }}</textarea>
        </fieldset>
    </fieldset>
</div>
