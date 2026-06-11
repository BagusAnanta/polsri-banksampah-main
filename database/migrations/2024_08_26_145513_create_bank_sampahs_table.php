<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankSampahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_sampahs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('jenis_sampah_id')->unsigned()->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->bigInteger('qty')->nullable();
            $table->string('tanggal_setor')->nullable();

            $table->foreign('jenis_sampah_id')->references('id')->on('jenis_sampahs')->onDelete('cascade');    
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');    
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
        Schema::dropIfExists('bank_sampahs');
    }
}
