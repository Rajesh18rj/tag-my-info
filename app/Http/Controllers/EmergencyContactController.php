<?php

namespace App\Http\Controllers;

use App\Models\EmergencyContact;
use App\Models\Profile;
use Illuminate\Http\Request;

class EmergencyContactController extends Controller
{
    public function store(Request $request, Profile $profile)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'relationship' => 'nullable|string|max:255',
            'mobile_number' => 'required|string|max:15',

        ]);

        $profile->emergencyContacts()->create($validated);

        return redirect()->route('profiles.edit', $profile->id)
            ->with('success', 'Contact added successfully.');
    }

    public function update(Request $request, Profile $profile, EmergencyContact $emergencyContact)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'relationship' => 'nullable|string|max:255',
            'mobile_number' => 'required|string|max:15',
        ]);

        $emergencyContact->update($validated);

        return redirect()->route('profiles.edit', $profile->id,)
            ->with('success', 'Contact updated successfully.');
    }

    public function destroy(Profile $profile, EmergencyContact $emergencyContact)
    {
        $emergencyContact->delete();

        return redirect()->route('profiles.edit', $profile->id)
            ->with('success', 'Contact deleted successfully.');
    }
}
