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
        Schema::table('dinas_perindustrian_perdagangan', function (Blueprint $table) {
            $table->string('gambar_bahan_pokok')->nullable()->after('jenis_bahan_pokok');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dinas_perindustrian_perdagangan', function (Blueprint $table) {
            $table->dropColumn('gambar_bahan_pokok');
        });
    }
};
