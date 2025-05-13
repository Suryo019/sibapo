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
        Schema::create('dinas_ketahanan_pangan_peternakan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('jenis_komoditas');
            $table->dateTime('tanggal_input');
            $table->float('ton_ketersediaan');
            $table->float('ton_kebutuhan_perminggu');
            $table->float('ton_neraca_mingguan');
            $table->enum('keterangan', ['Surplus', 'Defisit', 'Seimbang']);
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
        Schema::dropIfExists('dinas_ketahanan_pangan_peternakan');
    }
};
