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
        Schema::create('employer_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('nama_perusahaan', 100);
            $table->string('nib_atau_ijin', 50);
            $table->string('kategori_industri', 50);
            $table->enum('skala_perusahaan', ['Mikro (UMKM)', 'Menengah', 'Besar / Korporasi']);
            $table->text('deskripsi_singkat')->nullable();
            $table->text('alamat_kantor');
            $table->unsignedBigInteger('wilayah_id')->nullable();
            $table->string('website', 100)->nullable();
            $table->string('no_telp_hrd', 15)->nullable();
            $table->string('email_rekrutmen', 100)->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamps();

            $table->index('wilayah_id');
            $table->index('is_verified');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employer_profiles');
    }
};
