<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\VetDetail;
use Illuminate\Http\Request;

class VetDetailsController extends Controller
{
    public function store(Request $request, Profile $profile)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'personal_number' => 'required|string|max:25',
            'address' => 'nullable|string',

        ]);

        $profile->vetDetails()->create($validated);

        return redirect()->route('profiles.edit', $profile->id)
            ->with('success', 'Vet Detail added successfully.');
    }

    public function update(Request $request, Profile $profile, VetDetail $vetDetail)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'personal_number' => 'required|string|max:25',
            'address' => 'nullable|string',
        ]);

        $vetDetail->update($validated);

        return redirect()->route('profiles.edit', $profile->id,)
            ->with('success', 'Vet Detail updated successfully.');
    }

    public function destroy(Profile $profile, VetDetail $vetDetail)
    {
        $vetDetail->delete();

        return redirect()->route('profiles.edit', $profile->id)
            ->with('success', 'Vet Detail deleted successfully.');
    }
}
