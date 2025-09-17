<?php

namespace App\Http\Controllers;

use App\Models\HealthInsurance;
use App\Models\Profile;
use Illuminate\Http\Request;

class HealthInsuranceController extends Controller
{
    public function store(Request $request, Profile $profile)
    {
        $validated = $request->validate([
            'insurance_company_name' => 'required|string|max:255',
            'insurance_notes' => 'nullable|string',

        ]);

        $profile->healthInsurances()->create($validated);

        return redirect()->route('profiles.edit', $profile->id)
            ->with('success', 'Health Insurance added successfully.');
    }

    public function update(Request $request, Profile $profile, HealthInsurance $healthInsurance)
    {
        $validated = $request->validate([
            'insurance_company_name' => 'required|string|max:255',
            'insurance_notes' => 'nullable|string',
        ]);

        $healthInsurance->update($validated);

        return redirect()->route('profiles.edit', $profile->id,)
            ->with('success', 'Health Insurance updated successfully.');
    }

    public function destroy(Profile $profile, HealthInsurance $healthInsurance)
    {
        $healthInsurance->delete();

        return redirect()->route('profiles.edit', $profile->id)
            ->with('success', 'Health Insurance deleted successfully.');
    }
}
