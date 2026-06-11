<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTabungansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabungans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('bank_sampah_id')->unsigned();
            $table->date('tanggal');
            $table->decimal('debit', 10, 2)->nullable();
            $table->decimal('kredit', 10, 2)->nullable();
            $table->decimal('sisa_saldo', 10, 2);
            $table->foreign('bank_sampah_id')->references('id')->on('bank_sampahs')->onDelete('cascade');
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
        Schema::dropIfExists('tabungans');
    }
}
