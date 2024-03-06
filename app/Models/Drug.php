<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'strength',
        'dosage_form',
        'generic',
        'company',
        'applicable_for',
    ];
    public function dosage()
    {
        return $this->belongsTo(Dosage::class, 'dosage_form','base_name');
    }

    public function generic()
    {
        return $this->belongsTo(Generic::class, 'generic','name');
    }


    public function company()
    {
        return $this->belongsTo(Pharmaceutical::class, 'company','name');
    }

    public function applicable()
    {
        return $this->belongsTo(Applicable::class, 'applicables_for', 'category');
    }


}
