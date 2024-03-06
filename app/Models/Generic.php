<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Generic extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'composition',
        'indications',
        'therapeutic_class',
        'pharmacology',
        'dosage',
        'administration',
        'interaction' ,
        'contraindications',
        'side_effects',
        'pregnancy_lactation',
        'precautions',
        'pediatric_use',
        'overdose_effects',
        'reconstitution',
        'storage_condition',
        'applicable_for',
    ];
    public function applicable()
    {
        return $this->belongsTo(Applicable::class, 'applicables_for', 'category');
    }

    public function drugs()
    {
        return $this->hasMany(Drug::class, 'generic', 'name');
    }

}
