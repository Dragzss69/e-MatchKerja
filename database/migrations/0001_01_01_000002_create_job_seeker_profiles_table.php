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
        Schema::create('job_seeker_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('nik', 16)->unique();
            $table->string('nama_lengkap', 100);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->text('alamat_ktp');
            $table->string('file_ktp', 255)->nullable();
            $table->string('file_kk', 255)->nullable();
            $table->unsignedBigInteger('domisili_wilayah_id')->nullable();
            $table->string('no_hp', 15);
            $table->enum('status_verifikasi', ['Pending', 'Verified', 'Rejected'])->default('Pending');
            $table->enum('pendidikan_terakhir', ['SD', 'SMP', 'SMA/SMK', 'D3', 'S1', 'S2/S3']);
            $table->json('skills_tags')->nullable();
            $table->text('pengalaman_kerja')->nullable();
            $table->string('file_cv', 255)->nullable();
            $table->enum('status_kerja_saat_ini', ['Menganggur', 'Bekerja Serabutan', 'PHK']);
            $table->unsignedInteger('lama_menganggur')->default(0);
            $table->decimal('pendapatan_bulanan', 12, 2)->default(0);
            $table->unsignedInteger('jumlah_tanggungan')->default(0);
            $table->boolean('is_penerima_bansos_lain')->default(false);
            $table->timestamps();

            $table->index('domisili_wilayah_id');
            $table->index('status_verifikasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_seeker_profiles');
    }
};
