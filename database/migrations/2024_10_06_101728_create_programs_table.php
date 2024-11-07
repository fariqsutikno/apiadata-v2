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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('university_id')->constrained()->restrictOnDelete();
            $table->string('name');
            $table->enum('degree', ['D1', 'D2', 'D3', 'D4', 'Matrikulasi', 'S1', 'S2', 'S3']);
            $table->enum('program_type', ['Umum Murni', 'Umum Agama', 'Agama']);
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('program_categories')->nullOnDelete();
            $table->foreignId('country_id')->constrained()->restrictOnDelete()->nullable();
            $table->foreignId('province_id')->constrained()->restrictOnDelete()->nullable();
            $table->foreignId('regency_id')->constrained()->restrictOnDelete()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
