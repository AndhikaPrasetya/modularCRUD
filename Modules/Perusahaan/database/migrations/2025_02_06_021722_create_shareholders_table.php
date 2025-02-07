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
        Schema::create('shareholders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('akta_perusahaan_id');
            $table->foreign('akta_perusahaan_id')
            ->references('id')->on('akta_perusahaans')
            ->onDelete('cascade');
            $table->string('pemegang_saham'); 
            $table->decimal('jumlah_saham', 15, 2); 
            $table->decimal('saham_persen', 5, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shareholders');
    }
};
