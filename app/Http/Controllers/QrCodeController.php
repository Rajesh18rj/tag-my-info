<?php

namespace App\Http\Controllers;

use App\Models\QrCode;
use App\Models\QrCodeDetail;
use Illuminate\Http\Request;

class QrCodeController extends Controller
{
    // 1. Generate multiple QR codes
    public function generate(Request $request)
    {
        $count = $request->input('count', 10); // default 10 if not passed

        for ($i = 0; $i < $count; $i++) {
            // Generate unique 6-digit UID
            do {
                $uid = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            } while (QrCode::where('uid', $uid)->exists());

            // Generate random 4-digit PIN
            $pin = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

            QrCode::create([
                'code'   => uniqid('qr_'),
                'uid'    => $uid,
                'pin'    => $pin,
                'status' => false,
            ]);
        }

        return redirect()->route('qr.list')->with('success', "$count QR codes generated!");
    }


    // 2. Show list of QR codes
    public function list()
    {
        $qrcodes = QrCode::with('detail')->orderBy('created_at')->get();
        return view('qr.qr-list', compact('qrcodes'));
    }

    // 3. Show form to map data
    public function showForm()
    {
        $qr = QrCode::where('status', false)->orderBy('created_at', 'asc')->first();

        if (!$qr) {
            return redirect()->route('qr.list')->with('error', 'No free QR codes available.');
        }

        return view('qr.qr-form', compact('qr'));
    }

    // 4. Store mapping
    public function storeForm(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'description' => 'nullable|string',
            'uid' => 'required|string|digits:6',
            'pin' => 'required|string|digits:4',
        ]);

        // ✅ Find QR by UID & PIN instead of qr_code_id
        $qr = QrCode::where('uid', $request->uid)
            ->where('pin', $request->pin)
            ->first();

        if (!$qr) {
            return redirect()->back()->with('error', 'Invalid UID or PIN. Please try again.');
        }

        if ($qr->status) {
            return redirect()->back()->with('error', 'This QR code is already used.');
        }

        QrCodeDetail::create([
            'qr_code_id' => $qr->id,
            'name' => $request->name,
            'email' => $request->email,
            'description' => $request->description,
        ]);

        $qr->update(['status' => true]);

        return redirect()->route('qr.list')->with('success', 'Data mapped successfully!');
    }


    public function showDetails($id)
    {
        $qr = QrCode::with('detail')->findOrFail($id);

        if (!$qr->status) {
            return "No details mapped yet for this QR Code.";
        }
        return view('qr.qr-details', compact('qr'));
    }

}
