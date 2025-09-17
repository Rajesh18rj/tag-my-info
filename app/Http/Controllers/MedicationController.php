<?php

namespace App\Http\Controllers;

use App\Models\Medication;
use App\Models\Profile;
use Illuminate\Http\Request;

class MedicationController extends Controller
{
    public function store(Request $request, Profile $profile)
    {
        $validated = $request->validate([
            'medication_name' => 'required|string|max:255',
            'dosage' => 'nullable|string|max:255',
            'dosage_unit' => 'nullable',
            'frequency' => 'nullable',
            'frequency_type' => 'nullable',
            'notes' => 'nullable|string',
        ]);

        $profile->medications()->create($validated);

        return redirect()->route('profiles.edit', $profile->id)
            ->with('success', 'Medication added successfully.');
    }

    public function update(Request $request, Profile $profile, Medication $medication)
    {
        $validated = $request->validate([
            'medication_name' => 'required|string|max:255',
            'dosage' => 'nullable|string|max:255',
            'dosage_unit' => 'nullable',
            'frequency' => 'nullable',
            'frequency_type' => 'nullable',
            'notes' => 'nullable|string',
        ]);

        $medication->update($validated);

        return redirect()->route('profiles.edit', $profile->id,)
            ->with('success', 'Medication updated successfully.');
    }

    public function destroy(Profile $profile, Medication $medication)
    {
        $medication->delete();

        return redirect()->route('profiles.edit', $profile->id)
            ->with('success', 'Medication deleted successfully.');
    }
}
