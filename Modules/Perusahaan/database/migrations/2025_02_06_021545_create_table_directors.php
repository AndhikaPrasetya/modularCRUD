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
        Schema::create('directors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('akta_perusahaan_id');
            $table->foreign('akta_perusahaan_id')
            ->references('id')->on('akta_perusahaans')
            ->onDelete('cascade');
            $table->string('nama_direktur');
            $table->string('jabatan_direktur');
            $table->integer('durasi_jabatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('directors');
    }
};
