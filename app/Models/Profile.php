<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded = [];

    // Relations
    public function allergies()
    {
        return $this->hasMany(Allergy::class);
    }
    public function medications()
    {
        return $this->hasMany(Medication::class);
    }

    public function emergencyContacts()
    {
        return $this->hasMany(EmergencyContact::class);
    }

    public function healthInsurances()
    {
        return $this->hasMany(HealthInsurance::class);
    }
    public function vitalMedicalConditions()
    {
        return $this->hasMany(VitalMedicalCondition::class);
    }
    public function petOwners()
    {
        return $this->hasMany(PetOwner::class);
    }
    public function vetDetails()
    {
        return $this->hasMany(VetDetail::class);
    }
    public function instructions()
    {
        return $this->hasMany(Instruction::class);
    }

    public function qrCodeDetails()
    {
        return $this->hasMany(QrCodeDetail::class);
    }

    public function qrDetails()
    {
        return $this->hasMany(\App\Models\QrCodeDetail::class);
    }

}
