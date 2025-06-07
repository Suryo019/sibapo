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
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_admin')->default(false);
            $table->foreignId('role_id');
            $table->dateTime('tanggal_pesan');
            $table->boolean('is_read')->default(false);
            $table->boolean('is_completed')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->text('pesan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};
