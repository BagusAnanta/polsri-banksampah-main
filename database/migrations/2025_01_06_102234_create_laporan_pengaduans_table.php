<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanPengaduansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('laporan_pengaduans', function (Blueprint $table) {
            Schema::create('laporan_pengaduans', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('box_sampah_id');
                $table->foreign('box_sampah_id')->references('id')->on('box_sampahs')->onDelete('cascade');
                $table->unsignedBigInteger('user_id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->text('catatan');
                $table->timestamps();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('laporan_pengaduans', function (Blueprint $table) {
            //
        });
    }
}
