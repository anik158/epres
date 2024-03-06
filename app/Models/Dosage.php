<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'short_name',
        'base_name',
    ];

    public function drugs()
    {
        return $this->hasMany(Drug::class, 'dosage_form', 'base_name');
    }
}
