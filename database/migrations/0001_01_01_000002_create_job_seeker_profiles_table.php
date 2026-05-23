<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_seeker_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            $table->string('nik', 16)->unique();
            $table->string('nama_lengkap', 100);
            $table->date('tanggal_lahir');
            
            // Diperbaiki
            $table->enum('jenis_kelamin', ['L', 'P']);
            
            $table->text('alamat_ktp');
            $table->string('file_ktp', 255)->nullable();
            $table->string('file_kk', 255)->nullable();
            $table->string('no_hp', 15);
            
            // Diubah ke string agar lebih fleksibel
            $table->string('pendidikan_terakhir');
            
            $table->json('skills_tags')->nullable();
            $table->text('pengalaman_kerja')->nullable();
            $table->string('file_cv', 255)->nullable();
            
            // Diperbaiki
            $table->enum('status_kerja_saat_ini', [
                'Menganggur', 
                'Bekerja', 
                'Freelance', 
                'Wirausaha'
            ]);
            
            $table->unsignedInteger('lama_menganggur')->default(0);
            $table->decimal('pendapatan_bulanan', 12, 2)->default(0);
            $table->unsignedInteger('jumlah_tanggungan')->default(0);
            $table->boolean('is_penerima_bansos_lain')->default(false);
            $table->enum('status_verifikasi', ['Unverified', 'Verified', 'Rejected'])->default('Unverified');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_seeker_profiles');
    }
};