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
        Schema::create('alumnis', function (Blueprint $table) {
            $table->id();
            $table->string('alumni_code');
            $table->string('full_name');
            $table->string('alias')->nullable();
            $table->string('birth_place');
            $table->date('birth_date');
            $table->string('nik')->unique()->nullable();
            $table->string('nism')->unique();
            $table->string('nisn')->unique();
            $table->string('passport_number')->nullable();
            $table->boolean('is_life')->default(true);
            $table->enum('account_status', ['Aktif', 'Belum Aktif', 'Ditangguhkan', 'Dinonaktifkan'])->default('Belum Aktif');
            $table->enum('marital_status', ['Menikah', 'Lajang', 'Cerai Talak', 'Cerai Mati'])->default('Lajang');
            $table->decimal('ma_average', total: 8, places: 2)->nullable();
            $table->decimal('im_average', total: 8, places: 2)->nullable();
            $table->string('whatsapp');
            $table->string('emergency_contact');
            $table->string('email');
            $table->string('linkedin')->nullable();
            $table->string('photo_link');
            $table->string('drive_link');
            $table->string('address')->nullable();
            $table->string('predicate')->nullable();
            $table->foreignId('gen_id')->constrained()->restrictOnDelete();
            $table->foreignId('country_id')->constrained()->restrictOnDelete()->nullable();
            $table->foreignId('province_id')->constrained()->restrictOnDelete()->nullable();
            $table->foreignId('regency_id')->constrained()->restrictOnDelete()->nullable();
            $table->foreignId('district_id')->constrained()->restrictOnDelete()->nullable();
            $table->foreignId('village_id')->constrained()->restrictOnDelete()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnis');
    }
};
