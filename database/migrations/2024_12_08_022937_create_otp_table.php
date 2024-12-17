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
        Schema::create('otp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumni_id')->constrained()->cascadeOnDelete();
            $table->string('whatsapp');
            $table->string('otp')->nullable();
            $table->string('expired_at')->nullable();
            $table->string('verified_at')->nullable();
            $table->boolean('is_actived')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otp');
    }
};
