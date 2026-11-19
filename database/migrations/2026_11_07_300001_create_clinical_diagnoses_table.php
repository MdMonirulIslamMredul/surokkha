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
        Schema::create('clinical_diagnoses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category', 150)->index();
            $table->string('subcategory', 150)->nullable()->index();
            $table->string('name', 255)->index();
            $table->string('code', 50)->nullable();
            $table->text('description')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinical_diagnoses');
    }
};

