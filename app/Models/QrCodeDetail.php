<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QrCodeDetail extends Model
{
    protected $guarded = [];

    public function qrCode()
    {
        return $this->belongsTo(QrCode::class);
    }
}
