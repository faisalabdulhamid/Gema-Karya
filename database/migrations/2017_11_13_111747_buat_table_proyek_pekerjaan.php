<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BuatTableProyekPekerjaan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyek_pekerjaan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('initial');
            $table->unsignedInteger('harga');
            $table->tinyInteger('durasi');
            $table->float('bobot', 5, 2);
            $table->tinyInteger('jumlah_minggu');
            $table->timestamps();
            $table->unsignedInteger('proyek_id');
            $table->unsignedInteger('pekerjaan_id');

            $table->foreign('proyek_id')
              ->references('id')
              ->on('proyek')
              ->onDelete('cascade');
            $table->foreign('pekerjaan_id')
              ->references('id')
              ->on('pekerjaan')
              ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proyek_pekerjaan');
    }
}
