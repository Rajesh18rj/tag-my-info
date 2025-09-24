<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QrCode extends Model
{
    protected $guarded = [];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
    public function detail()
    {
        return $this->hasOne(QrCodeDetail::class);
    }

    // Relationship with qr_code_details
    public function details()
    {
        return $this->hasMany(QrCodeDetail::class);
    }

    public function batch()
    {
        return $this->belongsTo(QrBatch::class, 'batch_id');
    }
}
