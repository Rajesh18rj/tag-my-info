<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QrCode extends Model
{
    protected $guarded = [];

    public function detail()
    {
        return $this->hasOne(QrCodeDetail::class);
    }

    // Relationship with qr_code_details
    public function details()
    {
        return $this->hasOne(QrCodeDetail::class, 'qr_code_id');
    }
}
