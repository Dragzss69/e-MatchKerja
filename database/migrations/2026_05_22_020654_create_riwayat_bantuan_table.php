<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('riwayat_bantuan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_id')
                  ->constrained('pengajuan_bantuan')
                  ->onDelete('cascade');
            
            $table->decimal('nominal_diterima', 15, 2);
            $table->date('tanggal_penyaluran');
            $table->string('bukti_penyaluran')->nullable(); // path file bukti
            $table->text('keterangan')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('riwayat_bantuan');
    }
};