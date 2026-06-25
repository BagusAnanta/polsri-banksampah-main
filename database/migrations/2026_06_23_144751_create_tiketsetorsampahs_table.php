<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTiketsetorsampahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tiketsetorsampahs', function (Blueprint $table) {
            $table->uuid('tiketsampah_id')->primary();
            $table->unsignedInteger('tiketsampah_inc')->nullable();
            $table->uuid('masyarakat_id');
            $table->foreign('masyarakat_id')->references('masyarakat_id')->on('masyarakats')->onDelete('cascade');
            $table->uuid('banksampah_id');
            $table->foreign('banksampah_id')->references('banksampah_id')->on('banksampahusers')->onDelete('cascade');
            $table->integer('berat_sampah');
            $table->integer('berat_sampah_actual');
            $table->integer('poin');
            $table->string('qr_code_id');
            $table->enum('status', ['Menunggu', 'Selesai'])->default('Menunggu');
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
        Schema::dropIfExists('tiketsetorsampahs');
    }
}
