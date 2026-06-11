<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHargaToJenisSampahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jenis_sampahs', function (Blueprint $table) {
            $table->integer('harga')->nullable();
            $table->decimal('gramasi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jenis_sampahs', function (Blueprint $table) {
            $table->dropColumn('harga');
            $table->dropColumn('gramasi');
        });
    }
}
