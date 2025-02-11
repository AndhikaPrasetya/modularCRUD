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
        Schema::table('sewa_menyewa', function (Blueprint $table) {
            $table->unsignedBigInteger('jenis_dokumen_id')->after('lokasi_id');
            $table->foreign('jenis_dokumen_id')
            ->references('id')
            ->on('jenis_dokumen')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sewa_menyewa', function (Blueprint $table) {
            $table->dropColumn('jenis_dokumen_id'); 
        });
    }
};
