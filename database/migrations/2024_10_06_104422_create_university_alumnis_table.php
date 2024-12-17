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
        Schema::create('university_alumni', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumni_id')->constrained()->cascadeOnDelete();
            $table->foreignId('university_id')->constrained()->cascadeOnDelete();
            $table->foreignId('program_id')->constrained()->cascadeOnDelete();
            $table->tinyInteger('month_start')->nullable();
            $table->smallInteger('year_start')->nullable();
            $table->tinyInteger('month_end')->nullable();
            $table->smallInteger('year_end')->nullable();
            $table->enum('completion_status', ['Lulus', 'Sedang Berjalan', 'Berhenti'])->nullable();
            $table->enum('admission_path', ['SNBT', 'SNBP', 'UMPTKIN', 'SPANPTKIN', 'Jalur Prestasi', 'Mandiri', 'Kedinasan', 'Lainnya']);
            $table->enum('funding_source', ['Biaya Sendiri', 'Beasiswa', 'Lainnya'])->nullable();
            $table->boolean('is_accepted')->nullable();
            $table->boolean('is_enrolled')->nullable();
            $table->integer('priority')->nullable();
            $table->boolean('is_visible')->default(true);
            $table->integer('snbt_score')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('university_alumni');
    }
};
