<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateNewStatusValueToTiketsetorsampahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE tiketsetorsampahs MODIFY status ENUM('Menunggu', 'Selesai', 'Ditolak', 'Dibatalkan') NOT NULL DEFAULT 'Menunggu'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE tiketsetorsampahs MODIFY status ENUM('Menunggu', 'Selesai', 'Ditolak') NOT NULL DEFAULT 'Menunggu'");
    }
}
