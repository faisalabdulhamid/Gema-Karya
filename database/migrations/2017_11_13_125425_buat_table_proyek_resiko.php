<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BuatTableProyekResiko extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyek_resiko', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode', 2);
            $table->tinyInteger('nilai_dampak');
            $table->text('dampak');
            $table->tinyInteger('nilai_kemungkinan');
            $table->text('kemungkinan');
            $table->tinyInteger('level');
            $table->text('mitigasi');
            $table->timestamps();
            $table->unsignedInteger('proyek_id');
            $table->unsignedInteger('resiko_id');

            $table->foreign('proyek_id')
              ->references('id')
              ->on('proyek')
              ->onDelete('cascade');
            $table->foreign('resiko_id')
              ->references('id')
              ->on('resiko')
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
        Schema::dropIfExists('proyek_resiko');
    }
}
