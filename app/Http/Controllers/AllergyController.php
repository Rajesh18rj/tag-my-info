<?php

namespace App\Http\Controllers;

use App\Models\Allergy;
use App\Models\Profile;
use Illuminate\Http\Request;

class AllergyController extends Controller
{
    public function store(Request $request, Profile $profile)
    {
        $profile->load('allergies');

        $validated = $request->validate([
            'allergic_name' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $profile->allergies()->create($validated);

        return redirect()->route('profiles.edit', $profile->id)
            ->with('success', 'Allergy added successfully.');
    }

    public function update(Request $request, Profile $profile, Allergy $allergy)
    {
        $validated = $request->validate([
            'allergic_name' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $allergy->update($validated);

        return redirect()->route('profiles.edit', $profile->id,)
            ->with('success', 'Allergy updated successfully.');
    }

    public function destroy(Profile $profile, Allergy $allergy)
    {
        $allergy->delete();

        return redirect()->route('profiles.edit', $profile->id)
            ->with('success', 'Allergy deleted successfully.');
    }


}
