<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\QrBatch;
use App\Models\QrCode;
use App\Models\QrCodeDetail;
use Illuminate\Http\Request;
//use Intervention\Image\Image;
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


    // Generate QR Code

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
//        // Find the QR code
//        $qr = QrCode::findOrFail($id);
//
//        // Load all QR details with profiles linked to this QR
//        $qrDetails = QrCodeDetail::with('profile')
//            ->where('qr_code_id', $id)
//            ->get();
//
//        if ($qrDetails->isEmpty()) {
//            return "No profiles mapped yet for this QR Code.";
//        }
//
//        //  Check if all linked profiles are private
//        $hasPublicProfile = $qrDetails->contains(function ($detail) {
//            return $detail->profile && $detail->profile->is_public;
//        });
//
//        if (! $hasPublicProfile) {
//            return response()->view('profiles.private-profile', compact('qr'), 403);
////             return "This profile is private.";
//        }
//
//        // If at least one profile is public, filter only public ones
//        $qrDetails = $qrDetails->filter(function ($detail) {
//            return $detail->profile && $detail->profile->is_public;
//        });
//
//        return view('qr.qr-details', compact('qr', 'qrDetails'));
//    }

    public function showDetails($uid)
    {
        // Find the QR code by UID
        $qr = QrCode::where('uid', $uid)->firstOrFail();

        // Load all QR details with profiles linked to this QR
        $qrDetails = QrCodeDetail::with('profile')
            ->where('qr_code_id', $qr->id)
            ->get();

        if ($qrDetails->isEmpty()) {
            return "No profiles mapped yet for this QR Code.";
        }

        // Check if all linked profiles are private
        $hasPublicProfile = $qrDetails->contains(function ($detail) {
            return $detail->profile && $detail->profile->is_public;
        });

        if (! $hasPublicProfile) {
            return response()->view('profiles.private-profile', compact('qr'), 403);
        }

        // Only keep public profiles
        $qrDetails = $qrDetails->filter(function ($detail) {
            return $detail->profile && $detail->profile->is_public;
        });

        return view('qr.qr-details', compact('qr', 'qrDetails'));
    }




//    public function download($id)
//    {
//        $qr = QrCode::findOrFail($id);
//
//        // Instead of raw data, encode a URL pointing to your details page
//        $data = url('/qr-details/' . $qr->id); // The page that will show details
//
//        // Optional: label below QR
//        $labelText = "ID: {$qr->uid} | PIN: {$qr->pin}";
//
//        $result = Builder::create()
//            ->writer(new PngWriter())
//            ->data($data)     // this is the URL
//            ->size(300)
//            ->margin(10)
//            ->labelText($labelText)
//            ->build();
//
//        $filename = "{$qr->code}.png";
//
//        return response($result->getString(), 200, [
//            'Content-Type' => $result->getMimeType(),
//            'Content-Disposition' => "attachment; filename=\"$filename\"",
//        ]);
//    }

    public function download($id)
    {
        // Fetch QR model
        $qr = \App\Models\QrCode::findOrFail($id);

        // Build QR (Endroid)
        $data = url('/view-details/' . $qr->uid);
        $result = \Endroid\QrCode\Builder\Builder::create()
            ->writer(new \Endroid\QrCode\Writer\PngWriter())
            ->data($data)
            ->size(300)
            ->margin(10)
            ->build();

        $filename = "{$qr->code}.png";

        if ($qr->profile_type === 'Human') {
            $templatePath = public_path('template2.jpg');

            if (!is_file($templatePath)) {
                return response('Template image missing at: ' . $templatePath, 500);
            }

            // Load template
            $ext = strtolower(pathinfo($templatePath, PATHINFO_EXTENSION));
            if ($ext === 'png') {
                $template = @imagecreatefrompng($templatePath);
                imagealphablending($template, true);
                imagesavealpha($template, true);
            } else {
                $template = @imagecreatefromjpeg($templatePath);
            }

            if (!$template) {
                return response('Failed to load template image', 500);
            }

            // Load QR
            $qrData = $result->getString();
            $qrImg = @imagecreatefromstring($qrData);
            if (!$qrImg) {
                imagedestroy($template);
                return response('QR image could not be created', 500);
            }

            // Resize QR to 200x200 (smaller)
            $qrResized = imagecreatetruecolor(200, 200);
            imagealphablending($qrResized, false);
            imagesavealpha($qrResized, true);
            $transparent = imagecolorallocatealpha($qrResized, 0, 0, 0, 127);
            imagefill($qrResized, 0, 0, $transparent);

            imagecopyresampled(
                $qrResized, $qrImg,
                0, 0, 0, 0,
                200, 200, imagesx($qrImg), imagesy($qrImg)
            );

            // Composite QR onto template (moved right a bit)
            imagecopy($template, $qrResized, 637, 80, 0, 0, 200, 200);

            // Add ID and PIN text (rotated 90° vertical)
            $font = public_path('fonts/Roboto-Bold.ttf');
            if (!is_file($font)) {
                imagedestroy($template);
                imagedestroy($qrImg);
                imagedestroy($qrResized);
                return response('Font not found at: ' . $font, 500);
            }

        // Colors
            $black = imagecolorallocate($template, 0, 0, 0);      // Values
            $darkGrey = imagecolorallocate($template, 130 , 130, 130); // Labels

            $fontSize = 24;

        // Full text as black (value part will remain)
            imagettftext($template, $fontSize, 90, 540, 260, $black, $font, "ID : " . (string)$qr->uid);

        // Overdraw only the label in dark grey at same position
            imagettftext($template, $fontSize, 90, 540, 260, $darkGrey, $font, "ID : ");

        // Same for PIN
            imagettftext($template, $fontSize, 90, 590, 260, $black, $font, "PIN : " . (string)$qr->pin);
            imagettftext($template, $fontSize, 90, 590, 260, $darkGrey, $font, "PIN : ");


            // Output as PNG
            ob_start();
            imagepng($template);
            $pngData = ob_get_clean();

            imagedestroy($template);
            imagedestroy($qrImg);
            imagedestroy($qrResized);

            return response($pngData, 200, [
                'Content-Type' => 'image/png',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            ]);
        }

        // Non-human: return plain QR
        return response($result->getString(), 200, [
            'Content-Type' => $result->getMimeType(),
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
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
            ->withQueryString(); // keeps ?type= in pagination URLs

        // Always return JSON if it's an AJAX request
        if ($request->ajax()) {
            return response()->json([
                'rows'       => view('qr.qr-list-rows', compact('qrcodes'))->render(),
                'pagination' => view('qr.qr-pagination', compact('qrcodes'))->render(),
            ]);
        }

        // Fallback for direct visits (not AJAX)
        return view('qr.qr-list', compact('qrcodes'));
    }


}
