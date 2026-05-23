<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('lowongan_kerja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perusahaan_id')->constrained('users')->onDelete('cascade');
            
            $table->string('posisi');
            $table->text('deskripsi');
            $table->decimal('gaji_min', 15, 2);
            $table->decimal('gaji_max', 15, 2)->nullable();
            
            $table->string('lokasi');
            $table->string('kecamatan')->nullable();
            
            $table->json('skill_dibutuhkan');        // contoh: ["Laravel", "MySQL"]
            $table->integer('kuota')->default(1);
            $table->date('deadline');
            
            $table->enum('status', ['aktif', 'ditutup'])->default('aktif');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lowongan_kerja');
    }
};