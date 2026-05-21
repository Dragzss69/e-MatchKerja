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
        Schema::create('job_seeker_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pencari_kerja_id')->constrained('job_seeker_profiles')->cascadeOnDelete();
            $table->foreignId('petugas_id')->constrained('users')->cascadeOnDelete();
            $table->boolean('is_nik_valid')->default(false);
            $table->boolean('tempatis_kondisi_ekonomi_sesuai')->default(false);
            $table->text('catatan_petugas')->nullable();
            $table->enum('status_hasil', ['Disetujui', 'Ditolak']);
            $table->dateTime('tanggal_verifikasi');
            $table->timestamps();

            $table->index('status_hasil');
            $table->index('tanggal_verifikasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_seeker_verifications');
    }
};
