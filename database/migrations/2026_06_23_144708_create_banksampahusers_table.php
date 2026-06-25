<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBanksampahusersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banksampahusers', function (Blueprint $table) {
            $table->uuid('banksampah_id')->primary();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->string('username');
            $table->string('password');
            $table->string('nama_bank_sampah');
            $table->text('alamat')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('jam_operasional')->nullable();
            $table->string('nomor_telepon')->nullable();
            $table->text('deskripsi')->nullable();
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
        Schema::dropIfExists('banksampahusers');
    }
}
