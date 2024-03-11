<?php

namespace App\Models;

use App\Search\ElasticSearchObserver;
use App\Search\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    use HasFactory;
    use Searchable;


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

    protected static function boot()
    {
        parent::boot();

        static::observe(ElasticSearchObserver::class);
    }

    public function toElasticsearchDocumentArray(): array
    {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'strength' => $this->strength,
            'dosage_form' => $this->dosage_form,
            'generic' => $this->generic,
            'company' => $this->company,
            'applicable_for' => $this->applicable_for,
        ];
    }



}
