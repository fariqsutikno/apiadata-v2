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
        Schema::table('alumnis', function (Blueprint $table) {
            $table->string('father_name');
            $table->boolean('father_status');
            $table->string('mother_name');
            $table->boolean('mother_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alumnis', function (Blueprint $table) {
            $table->dropColumn('father_name');
            $table->dropColumn('father_status');
            $table->dropColumn('mother_name');
            $table->dropColumn('mother_status');
        });
    }
};
