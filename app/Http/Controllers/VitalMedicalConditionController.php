<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\VitalMedicalCondition;
use Illuminate\Http\Request;

class VitalMedicalConditionController extends Controller
{
    public function store(Request $request, Profile $profile)
    {
        $validated = $request->validate([
            'condition_name' => 'required|string|max:255',
            'notes' => 'nullable|string',

        ]);

        $profile->vitalMedicalConditions()->create($validated);

        return redirect()->route('profiles.edit', $profile->id)
            ->with('success', 'Medical Condition added successfully.');
    }

    public function update(Request $request, Profile $profile, VitalMedicalCondition $vitalMedicalCondition)
    {
        $validated = $request->validate([
            'condition_name' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $vitalMedicalCondition->update($validated);

        return redirect()->route('profiles.edit', $profile->id,)
            ->with('success', 'Medical Condition updated successfully.');
    }

    public function destroy(Profile $profile, VitalMedicalCondition $vitalMedicalCondition)
    {
        $vitalMedicalCondition->delete();

        return redirect()->route('profiles.edit', $profile->id)
            ->with('success', 'Medical Condition deleted successfully.');
    }
}
