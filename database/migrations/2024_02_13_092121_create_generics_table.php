<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('generics', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('composition');
            $table->text('indications');
            $table->text('therapeutic_class');
            $table->text('pharmacology');
            $table->text('dosage');
            $table->text('administration');
            $table->text('interaction');
            $table->text('contraindications');
            $table->text('side_effects');
            $table->text('pregnancy_lactation');
            $table->text('precautions');
            $table->text('pediatric_use');
            $table->text('overdose_effects');
            $table->text('reconstitution');
            $table->text('storage_condition');
            $table->string('applicable_for');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generics');
    }
};
