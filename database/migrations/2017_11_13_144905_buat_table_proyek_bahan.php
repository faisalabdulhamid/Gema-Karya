<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BuatTableProyekBahan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyek_bahan', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('jumlah');
            $table->timestamps();
            $table->unsignedInteger('proyek_id');
            $table->unsignedInteger('bahan_id');

            $table->foreign('proyek_id')
              ->references('id')
              ->on('proyek')
              ->onDelete('cascade');
            $table->foreign('bahan_id')
              ->references('id')
              ->on('bahan_baku')
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
        Schema::dropIfExists('proyek_bahan');
    }
}
