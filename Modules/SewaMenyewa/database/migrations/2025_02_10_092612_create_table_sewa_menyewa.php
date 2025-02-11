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
        Schema::create('sewa_menyewa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lokasi_id');
            $table->foreign('lokasi_id')
            ->references('id')
            ->on('lokasi')
            ->onDelete('cascade');
            $table->text('tentang');
            $table->string('no_dokumen');
            $table->string('nama_notaris');
            $table->date('tanggal_dokumen');
            $table->string('sign_by');
            $table->string('nama_pemilik_awal');
            $table->date('sewa_awal');
            $table->date('sewa_akhir');
            $table->string('sewa_grace_period')->nullable();
            $table->date('sewa_handover');
            $table->string('no_sertifikat');
            $table->enum('jenis_sertifikat',['HGB','SHM']);
            $table->string('tgl_sertifikat');
            $table->date('tgl_akhir_sertifikat');  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sewa_menyewa');
    }
};
