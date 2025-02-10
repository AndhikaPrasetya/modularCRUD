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
        Schema::create('lokasi', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid_profile_perusahaan');
            $table->foreign('uid_profile_perusahaan')
            ->references('id')
            ->on('profile_perusahaans')
            ->onDelete('cascade');
            $table->string('nama');
            $table->text('alamat');
            $table->string('phone');
            $table->enum('category',['office', 'gudang/workshop', 'outlet/clinic']);
            $table->enum('type',['mall', 'non-mall']);
            $table->enum('status',['fadly_own', 'rent', 'zap_own']);
            $table->integer('luas');
            $table->integer('harga');
            $table->integer('pph');
            $table->integer('ppn');
            $table->integer('deposit');
            $table->enum('pembayar_pbb',['fadly', 'sharing', 'pemilik', 'zap']);
            $table->string('no_pbb');
            $table->string('id_pln');
            $table->string('daya');
            $table->string('id_pdam');
            $table->integer('denda_telat_bayar');
            $table->integer('denda_pembatalan');
            $table->integer('denda_pengosongan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lokasi');
    }
};
