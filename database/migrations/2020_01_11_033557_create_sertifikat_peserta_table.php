<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSertifikatPesertaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sertifikat_peserta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('no');
            $table->unsignedInteger('peserta_id');
            $table->unsignedInteger('sertifikat_id');
            $table->string('nomor');
            $table->string('barcode')->nullable();
            $table->string('kualifikasi')->nullable();
            $table->unsignedInteger('tahun');
            $table->string('bidang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sertifikat_peserta');
    }
}
