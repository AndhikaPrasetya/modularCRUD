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
        Schema::create('profile_perusahaans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama');
            $table->text('alamat');
            $table->string('no_telp');
            $table->string('email')->unique();
            $table->integer('kode_pos');
            $table->string('no_domisili')->nullable();
            $table->string('nama_domisili')->nullable();
            $table->text('alamat_domisili')->nullable();
            $table->string('province_domisili')->nullable();
            $table->string('kota_domisili')->nullable();
            $table->string('no_npwp')->nullable();
            $table->string('nama_npwp')->nullable();
            $table->text('alamat_npwp')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_perusahaans');
    }
};
