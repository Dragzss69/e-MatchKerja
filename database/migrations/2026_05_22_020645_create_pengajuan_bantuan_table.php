<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('pengajuan_bantuan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pencari_kerja_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->enum('jenis_bantuan', ['subsidi_upah', 'pelatihan', 'modal_umkm', 'lainnya']);
            $table->text('alasan');
            $table->decimal('nominal_diajukan', 15, 2)->nullable();

            $table->enum('status', [
                'pending', 
                'diverifikasi', 
                'disetujui', 
                'ditolak', 
                'disalurkan'
            ])->default('pending');

            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->text('catatan_verifikasi')->nullable();
            $table->timestamp('tanggal_verifikasi')->nullable();

            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->text('catatan_approval')->nullable();
            $table->timestamp('tanggal_approval')->nullable();

            $table->timestamp('tanggal_penyaluran')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengajuan_bantuan');
    }
};