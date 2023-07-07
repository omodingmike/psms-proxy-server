<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'age', 'location', 'phone', 'email', 'discharge_date', 'vital_signs', 'medication', 'allergies', 'emergency_contacts', 'medical_notes', 'device_id'
    ];
}
