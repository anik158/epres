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
            $table->text('composition')->nullable();
            $table->text('indications')->nullable();
            $table->text('therapeutic_class')->nullable();
            $table->text('pharmacology')->nullable();
            $table->text('dosage')->nullable();
            $table->text('administration')->nullable();
            $table->text('interaction')->nullable();
            $table->text('contraindications')->nullable();
            $table->text('side_effects')->nullable();
            $table->text('pregnancy_lactation')->nullable();
            $table->text('precautions')->nullable();
            $table->text('pediatric_use')->nullable();
            $table->text('overdose_effects')->nullable();
            $table->text('reconstitution')->nullable();
            $table->text('storage_condition')->nullable();
            $table->string('applicable_for')->nullable();
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
