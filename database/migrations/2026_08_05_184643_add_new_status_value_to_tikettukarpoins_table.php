<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddNewStatusValueToTikettukarpoinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       DB::statement("ALTER TABLE tikettukarpoins MODIFY status ENUM('Menunggu', 'Selesai', 'Dibatalkan') NOT NULL DEFAULT 'Menunggu'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE tikettukarpoins MODIFY status ENUM('Menunggu', 'Selesai') NOT NULL DEFAULT 'Menunggu'");
    }
}
