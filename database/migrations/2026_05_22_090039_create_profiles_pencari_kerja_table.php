<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('profiles_pencari_kerja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            
            $table->string('nik')->unique();
            $table->string('nama_lengkap');
            $table->integer('usia');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->text('alamat');
            $table->string('kecamatan');
            $table->string('kabupaten');
            $table->string('provinsi')->default('Sulawesi Tengah');
            
            $table->enum('pendidikan_terakhir', ['SD', 'SMP', 'SMA/SMK', 'D3', 'S1', 'S2', 'S3']);
            $table->string('jurusan')->nullable();
            
            $table->json('skill')->nullable(); // contoh: ["Microsoft Office", "Desain Grafis"]
            $table->integer('pengalaman_kerja_tahun')->default(0);
            $table->text('pengalaman_kerja_detail')->nullable();
            
            $table->enum('status_pekerjaan', ['menganggur', 'bekerja', 'freelance', 'wirausaha', 'pelajar']);
            $table->decimal('pendapatan_bulanan', 15, 2)->default(0);
            $table->integer('jumlah_tanggungan')->default(0);
            $table->integer('lama_menganggur_bulan')->default(0);
            
            $table->string('cv_path')->nullable();
            $table->string('portofolio_path')->nullable();
            
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('profiles_pencari_kerja');
    }
};