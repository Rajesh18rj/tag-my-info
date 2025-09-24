<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QrBatch extends Model
{
    protected $guarded = [];

    public function qrcodes()
    {
        return $this->hasMany(QrCode::class, 'batch_id');
    }
}
