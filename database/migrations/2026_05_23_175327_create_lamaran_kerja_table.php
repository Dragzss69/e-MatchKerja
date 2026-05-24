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
        Schema::create('lamaran_kerja', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke Pencari Kerja
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();
            
            // Relasi ke Lowongan Kerja
            $table->foreignId('lowongan_id')
                  ->constrained('lowongan_kerja')
                  ->cascadeOnDelete();

            // File Upload
            $table->string('cv_path')->nullable();
            $table->string('portofolio_path')->nullable();
            
            // Catatan tambahan dari pelamar
            $table->text('catatan')->nullable();

            // Status Lamaran
            $table->enum('status', [
                'pending',
                'dipanggil_wawancara',
                'diterima',
                'ditolak'
            ])->default('pending');

            $table->timestamps();

            // Satu user tidak boleh melamar lowongan yang sama 2x
            $table->unique(['user_id', 'lowongan_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lamaran_kerja');
    }
};