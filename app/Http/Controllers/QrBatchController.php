<?php

namespace App\Http\Controllers;

use App\Models\QrBatch;
use App\Models\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

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

    public function download(QrBatch $batch)
    {
        $zipFileName = "batch_{$batch->id}.zip";
        $zipPath = storage_path("app/public/{$zipFileName}");

        $zip = new \ZipArchive;
        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
            foreach ($batch->qrcodes as $qr) {
                // Data points to the details page (just like single download)
                $data = url('/qr-details/' . $qr->id);

                // Label below QR
                $labelText = "ID: {$qr->uid} | PIN: {$qr->pin}";

                $qrImage = \Endroid\QrCode\Builder\Builder::create()
                    ->writer(new \Endroid\QrCode\Writer\PngWriter())
                    ->data($data)
                    ->size(300)
                    ->margin(10)
                    ->labelText($labelText)
                    ->build();

                // Save each QR with its code as filename
                $zip->addFromString("{$qr->code}.png", $qrImage->getString());
            }
            $zip->close();
        }

//        return response()->download($zipPath)->deleteFileAfterSend(true);
        return response()->download($zipPath);

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
