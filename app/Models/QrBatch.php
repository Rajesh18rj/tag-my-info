<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QrBatch extends Model
{
    protected $guarded = [];

    const STATUS_PENDING  = 'pending';
    const STATUS_SENDING  = 'sending';
    const STATUS_RECEIVED = 'received';
    const STATUS_VERIFIED = 'verified';

    public static function statuses(): array
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_SENDING,
            self::STATUS_RECEIVED,
            self::STATUS_VERIFIED,
        ];
    }

    public function qrcodes()
    {
        return $this->hasMany(QrCode::class, 'batch_id');
    }
}
