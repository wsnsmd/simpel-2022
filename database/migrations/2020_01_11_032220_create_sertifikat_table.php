<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSertifikatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sertifikat', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('diklat_jadwal_id')->unique();
            $table->boolean('barcode')->default(false);
            $table->boolean('kualifikasi')->default(false);
            $table->boolean('import')->default(false);
            $table->string('tempat');
            $table->date('tanggal');
            $table->string('jabatan');
            $table->string('nama');
            $table->string('pangkat');
            $table->string('nip');
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
        Schema::dropIfExists('sertifikat');
    }
}
