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
        Schema::create('akta_perusahaans', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid_profile_perusahaan');
            $table->foreign('uid_profile_perusahaan')
            ->references('id')
            ->on('profile_perusahaans')
            ->onDelete('cascade');
            $table->string('kode_akta');
            $table->string('nama_akta');
            $table->string('no_doc');
            $table->date('tgl_terbit');
            $table->string('nama_notaris');
            $table->text('keterangan')->nullable();
            $table->string('sk_kemenkum_ham');
            $table->enum('status',['active','expired']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akta_perusahaans');
    }
};
