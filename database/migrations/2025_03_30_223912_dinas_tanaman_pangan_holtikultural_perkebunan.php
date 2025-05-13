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
        Schema::create('dinas_tanaman_pangan_holtikultural_perkebunan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('jenis_komoditas');
            $table->dateTime('tanggal_input');
            $table->float('ton_volume_produksi');
            $table->float('hektar_luas_panen');
            $table->enum('aksi', ['buat', 'ubah', 'hapus']);
            $table->softDeletes();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dinas_tanaman_pangan_holtikultural_perkebunan');
    }
};
