<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicable extends Model
{
    use HasFactory;
    protected $fillable = [
        'category',
    ];


    public function generics()
    {
        return $this->hasMany(Generic::class, 'applicables_for', 'category');
    }

    public function drugs()
    {
        return $this->hasMany(Drug::class, 'applicables_for', 'category');
    }




}
