<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\QrCode;
use App\Models\QrCodeDetail;
use Illuminate\Http\Request;

class ProfileQrController extends Controller
{
    // Show the form to link a QR
    public function create(Profile $profile)
    {
        return view('profiles.link-qr', compact('profile'));
    }

    //Handle Linking
    public function store(Request $request, Profile $profile)
    {
        $request->validate([
            'uid'  => 'required|string|digits:6',
            'pin'  => 'required|string|digits:4',
            'name' => 'nullable|string|max:255',
        ]);

        $qr = QrCode::where('uid', $request->uid)
            ->where('pin', $request->pin)
            ->first();

        if (!$qr) {
            return back()->with('error', 'QR Code not found or invalid UID/PIN.');
        }

        // Check type match
        if ($qr->profile_type !== $profile->type) {
            return back()->with('error', "Type mismatch! This QR is for {$qr->profile_type} profiles, but this profile is {$profile->type}.");
        }

        // Check if this QR is already linked
        if ($qr->detail) {
            return back()->with('error', 'This QR is already linked to another profile.');
        }

        QrCodeDetail::create([
            'qr_code_id' => $qr->id,
            'profile_id' => $profile->id,
            'name'       => $request->name,
        ]);

        $qr->status = 1; // mark as used
        $qr->save();

        return redirect()->route('profiles.edit', $profile->id)
            ->with('success', 'QR Code linked successfully!');
    }

}
