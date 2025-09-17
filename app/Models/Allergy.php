<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Allergy extends Model
{
    protected $fillable = ['profile_id', 'allergic_name', 'notes'];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
