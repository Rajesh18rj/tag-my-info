<?php

namespace App\Http\Controllers;

use App\Models\PetOwner;
use App\Models\Profile;
use Illuminate\Http\Request;

class PetOwnerController extends Controller
{
    public function store(Request $request, Profile $profile)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'relationship' => 'nullable|string|max:255',
            'contact_number' => 'required|string|max:15',

        ]);

        $profile->petOwners()->create($validated);

        return redirect()->route('profiles.edit', $profile->id)
            ->with('success', 'Pet Owner added successfully.');
    }

    public function update(Request $request, Profile $profile, PetOwner $petOwner)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'relationship' => 'nullable|string|max:255',
            'contact_number' => 'required|string|max:15',
        ]);

        $petOwner->update($validated);

        return redirect()->route('profiles.edit', $profile->id,)
            ->with('success', 'Pet Owner updated successfully.');
    }

    public function destroy(Profile $profile, PetOwner $petOwner)
    {
        $petOwner->delete();

        return redirect()->route('profiles.edit', $profile->id)
            ->with('success', 'Pet Owner deleted successfully.');
    }
}
