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
        'indication',
        'applicable_for',
    ];
    public function applicable()
    {
        return $this->belongsTo(Applicable::class, 'applicables_for', 'category');
    }

}
