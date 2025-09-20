<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\QrCode;
use App\Models\QrCodeDetail;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QrCodeGenerator;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class QrCodeController extends Controller
{

    public function index()
    {
        $qrcodes = QrCode::orderBy('id', 'desc')
            ->paginate(15);
        return view('qr.qr-list', compact('qrcodes'));
    }

    public function showGenerateForm()
    {
        return view('qr.qr-generate');
    }

    public function generate(Request $request)
    {
        $request->validate([
            'count' => 'required|integer|min:1|max:1000',
            'profile_type' => 'required|in:Human,Pet,Valuables',
        ]);

        $count = $request->count;
        $profileType = $request->profile_type;

        for ($i = 0; $i < $count; $i++) {
            do {
                $uid = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            } while (QrCode::where('uid', $uid)->exists());

            $pin = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

            QrCode::create([
                'code'         => uniqid('qr_'),
                'uid'          => $uid,
                'pin'          => $pin,
                'status'       => false,
                'profile_type' => $profileType,
            ]);
        }

        return redirect()->route('qr.list')->with('success', "$count $profileType QR codes generated!");
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
            'name' => 'nullable|string|max:255',
            'uid' => 'required|string|digits:6',
            'pin' => 'required|string|digits:4',
        ]);

        //  Find QR by UID & PIN instead of qr_code_id
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
        ]);

        $qr->update(['status' => true]);

        return redirect()->route('qr.list')->with('success', 'Data mapped successfully!');
    }


    // QR Details
//    public function showDetails($id)
//    {
//        $qr = QrCode::with('detail')->findOrFail($id);
//
//        if (!$qr->status) {
//            return "No details mapped yet for this QR Code.";
//        }
//        return view('qr.qr-details', compact('qr'));
//    }

    public function showDetails($id)
    {
        // Find the QR code
        $qr = QrCode::findOrFail($id);

        // Load all QR details with profiles linked to this QR
        $qrDetails = QrCodeDetail::with('profile')
            ->where('qr_code_id', $id)
            ->get();

        if ($qrDetails->isEmpty()) {
            return "No profiles mapped yet for this QR Code.";
        }

        return view('qr.qr-details', compact('qr', 'qrDetails'));
    }




    public function download($id)
    {
        $qr = QrCode::findOrFail($id);

        // Instead of raw data, encode a URL pointing to your details page
        $data = url('/qr-details/' . $qr->id); // The page that will show details

        // Optional: label below QR
        $labelText = "UID: {$qr->uid} | PIN: {$qr->pin}";

        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($data)     // this is the URL
            ->size(300)
            ->margin(10)
            ->labelText($labelText)
            ->build();

        $filename = "{$qr->code}.png";

        return response($result->getString(), 200, [
            'Content-Type' => $result->getMimeType(),
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }

    public function filter(Request $request)
    {
        $type = $request->type;

        $qrcodes = QrCode::when($type, function ($query) use ($type) {
            $query->where('profile_type', $type);
        })
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->withQueryString();

        //  Always return JSON if it's an AJAX request
        if ($request->ajax()) {
            return response()->json([
                'rows'       => view('qr.qr-list-rows', compact('qrcodes'))->render(),
                'pagination' => view('qr.qr-pagination', compact('qrcodes'))->render(),
            ]);
        }

        return view('qr.qr-list', compact('qrcodes'));
    }

}
