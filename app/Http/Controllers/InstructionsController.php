<?php

namespace App\Http\Controllers;

use App\Models\Instruction;
use App\Models\Profile;
use Illuminate\Http\Request;

class InstructionsController extends Controller
{
    public function store(Request $request, Profile $profile)
    {

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $profile->instructions()->create($validated);

        return redirect()->route('profiles.edit', $profile->id)
            ->with('success', 'Instruction added successfully.');
    }

    public function update(Request $request, Profile $profile, Instruction $instruction)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $instruction->update($validated);

        return redirect()->route('profiles.edit', $profile->id,)
            ->with('success', 'Instruction updated successfully.');
    }

    public function destroy(Profile $profile, Instruction $instruction)
    {
        $instruction->delete();

        return redirect()->route('profiles.edit', $profile->id)
            ->with('success', 'Instruction deleted successfully.');
    }

}
