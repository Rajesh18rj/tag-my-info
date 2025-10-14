<?php

namespace App\Http\Controllers;

use App\Models\QrBatch;
use App\Models\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Str;

class QrBatchController extends Controller
{
    public function index()
    {
        $batches = QrBatch::with('qrcodes')->latest()->paginate(10);
        return view('qr.batch.index', compact('batches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'count' => 'required|integer|min:1|max:100',
            'profile_type' => 'required|in:Human,Pet,Valuables',
        ]);

        $batch = QrBatch::create(['count' => $request->count]);

        for ($i = 0; $i < $request->count; $i++) {
            do {
                $uid = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            } while (QrCode::where('uid', $uid)->exists());

            $pin = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

            QrCode::create([
                'code'         => uniqid('qr_'),
                'uid'          => $uid,
                'pin'          => $pin,
                'status'       => false,
                'profile_type' => $request->profile_type,
                'batch_id'     => $batch->id,
            ]);
        }

        return redirect()->route('qr.qr-batches.index')
            ->with('success', 'Batch created with ' . $request->count . ' QR codes.');
    }


//    public function download(QrBatch $batch)
//    {
//        $zipFileName = "batch_{$batch->id}.zip";
//        $zipPath = storage_path("app/public/{$zipFileName}");
//
//        $font = public_path('fonts/Roboto-Bold.ttf');
//
//
//        // Ensure parent dir exists
//        if (!is_dir(dirname($zipPath))) {
//            @mkdir(dirname($zipPath), 0775, true);
//        }
//
//        $zip = new \ZipArchive();
//        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
//            abort(500, 'Failed to create ZIP archive');
//        }
//
//        $templatePath = public_path('red2.jpg');
//        $fontPath = public_path('fonts/Roboto-Bold.ttf');
//
//        foreach ($batch->qrcodes as $qr) {
//            // Build QR contents
//            $data = url('/view-details/' . $qr->uid);
//
//            $qrImage = Builder::create()
//                ->writer(new PngWriter())
//                ->data($data)
//                ->size(300)
//                ->margin(10)
//                ->build();
//
//            // File name inside zip
//            $filename = trim($qr->code ?: ('qr_' . $qr->id));
//            $filename = Str::of($filename)->replace(['/', '\\'], '-'); // avoid path separators
//            $entryName = "batch_{$batch->id}_{$filename}.png";
//
//            // If profile is Human, composite onto template like single download
//            if ($qr->profile_type === 'Human' && is_file($templatePath) && is_file($fontPath)) {
//
//                // Load template
//                $ext = strtolower(pathinfo($templatePath, PATHINFO_EXTENSION));
//                if ($ext === 'png') {
//                    $template = @imagecreatefrompng($templatePath);
//                    imagealphablending($template, true);
//                    imagesavealpha($template, true);
//                } else {
//                    $template = @imagecreatefromjpeg($templatePath);
//                }
//
//                if ($template) {
//                    // QR image from Endroid
//                    $qrImg = @imagecreatefromstring($qrImage->getString());
//                    if ($qrImg) {
//                        // Resize QR to 200x200
//                        $qrResized = imagecreatetruecolor(200, 200);
//                        imagealphablending($qrResized, false);
//                        imagesavealpha($qrResized, true);
//                        $transparent = imagecolorallocatealpha($qrResized, 0, 0, 0, 127);
//                        imagefill($qrResized, 0, 0, $transparent);
//
//                        imagecopyresampled(
//                            $qrResized, $qrImg,
//                            0, 0, 0, 0,
//                            210, 210, imagesx($qrImg), imagesy($qrImg)
//                        );
//
//                        // Composite to same coords as single method
//                        imagecopy($template, $qrResized, 630, 74, 0, 0, 200, 200);
//
//                        // Colors
//                        $black = imagecolorallocate($template, 0, 0, 0);      // Values
//                        $darkGrey = imagecolorallocate($template, 130 , 130, 130); // Labels
//
//                        $fontSize = 30;
//
//                        // Full text as black (value part will remain)
//                        imagettftext($template, $fontSize, 90, 540, 280, $black, $font, "ID : " . (string)$qr->uid);
//
//                        // Overdraw only the label in dark grey at same position
//                        imagettftext($template, $fontSize, 90, 540, 280, $darkGrey, $font, "ID : ");
//
//                        // Same for PIN
//                        imagettftext($template, $fontSize, 90, 590, 280, $black, $font, "PIN : " . (string)$qr->pin);
//                        imagettftext($template, $fontSize, 90, 590, 280, $darkGrey, $font, "PIN : ");
//
//                        // Buffer final PNG
//                        ob_start();
//                        imagepng($template);
//                        $pngData = ob_get_clean();
//
//                        // Cleanup
//                        imagedestroy($template);
//                        imagedestroy($qrImg);
//                        imagedestroy($qrResized);
//
//                        // Write entry
//                        $zip->addFromString($entryName, $pngData); // binary safe per manual
//                    } else {
//                        // Fallback: plain QR if GD failed to create image from string
//                        $zip->addFromString($entryName, $qrImage->getString());
//                    }
//                } else {
//                    // Fallback: template missing/unloadable
//                    $zip->addFromString($entryName, $qrImage->getString());
//                }
//            } else {
//                // Non-human or missing assets: plain QR
//                $zip->addFromString($entryName, $qrImage->getString()); // binary safe
//            }
//        }
//
//        $zip->close();
//
//        // Return and remove after send
//        return response()->download($zipPath, $zipFileName, [
//            'Content-Type' => 'application/zip',
//            'Content-Disposition' => "attachment; filename=\"{$zipFileName}\"",
//        ])->deleteFileAfterSend(true);
//    }

    public function download(QrBatch $batch)
    {
        $zipFileName = "batch_{$batch->id}.zip";
        $zipPath = storage_path("app/public/{$zipFileName}");

        $font = public_path('fonts/Roboto-Bold.ttf');

        // Ensure parent dir exists
        if (!is_dir(dirname($zipPath))) {
            @mkdir(dirname($zipPath), 0775, true);
        }

        $zip = new \ZipArchive();
        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            abort(500, 'Failed to create ZIP archive');
        }

        $templates = [
            'red' => public_path('red_new.jpg'),
            'yellow' => public_path('yellow_new.jpg'),
        ];
        $fontPath = public_path('fonts/Roboto-Bold.ttf');

        $serial = 1;
        foreach ($batch->qrcodes as $qr) {
            $data = url('/view-details/' . $qr->uid);

            $qrImage = Builder::create()
                ->writer(new PngWriter())
                ->data($data)
                ->size(300)
                ->margin(10)
                ->build();

            $filename = trim($qr->code ?: ('qr_' . $qr->id));
            $filename = Str::of($filename)->replace(['/', '\\'], '-');


            foreach ($templates as $folder => $templatePath) {

                $entryName = "{$folder}/batch_{$batch->id}_{$filename}_{$serial}.png";


                if ($qr->profile_type === 'Human' && is_file($templatePath) && is_file($fontPath)) {
                    $ext = strtolower(pathinfo($templatePath, PATHINFO_EXTENSION));
                    if ($ext === 'png') {
                        $template = @imagecreatefrompng($templatePath);
                        imagealphablending($template, true);
                        imagesavealpha($template, true);
                    } else {
                        $template = @imagecreatefromjpeg($templatePath);
                    }

                    if ($template) {
                        $qrImg = @imagecreatefromstring($qrImage->getString());
                        if ($qrImg) {
                            $qrResized = imagecreatetruecolor(200, 200);
                            imagealphablending($qrResized, false);
                            imagesavealpha($qrResized, true);
                            $transparent = imagecolorallocatealpha($qrResized, 0, 0, 0, 127);
                            imagefill($qrResized, 0, 0, $transparent);

                            imagecopyresampled(
                                $qrResized, $qrImg,
                                0, 0, 0, 0,
                                210, 210, imagesx($qrImg), imagesy($qrImg)
                            );

                            imagecopy($template, $qrResized, 667, 95, 0, 0, 200, 200);

                            $black = imagecolorallocate($template, 0, 0, 0);
                            $darkGrey = imagecolorallocate($template, 130 , 130, 130);

                            $fontSize = 30;

                            imagettftext($template, $fontSize, 90, 570, 300, $black, $font, "ID : " . (string)$qr->uid);
                            imagettftext($template, $fontSize, 90, 570, 300, $darkGrey, $font, "ID : ");
                            imagettftext($template, $fontSize, 90, 630, 300, $black, $font, "PIN : " . (string)$qr->pin);
                            imagettftext($template, $fontSize, 90, 630, 300, $darkGrey, $font, "PIN : ");

                            ob_start();
                            imagepng($template);
                            $pngData = ob_get_clean();

                            imagedestroy($template);
                            imagedestroy($qrImg);
                            imagedestroy($qrResized);

                            $zip->addFromString($entryName, $pngData);
                        } else {
                            $zip->addFromString($entryName, $qrImage->getString());
                        }
                    } else {
                        $zip->addFromString($entryName, $qrImage->getString());
                    }
                } else {
                    $zip->addFromString($entryName, $qrImage->getString());
                }
            }
            $serial++;
        }


        $zip->close();

        return response()->download($zipPath, $zipFileName, [
            'Content-Type' => 'application/zip',
            'Content-Disposition' => "attachment; filename=\"{$zipFileName}\"",
        ])->deleteFileAfterSend(true);
    }



    public function updateStatus(Request $request, QrBatch $batch)
    {
        $request->validate([
            'status' => 'required|in:pending,sending,received,verified'
        ]);

        $batch->update(['status' => $request->status]);


        return response()->json([
            'success' => true,
            'status'  => $batch->status,
            'redirect' => route('qr.qr-batches.index')
        ]);

    }

}
