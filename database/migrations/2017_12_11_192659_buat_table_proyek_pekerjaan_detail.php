<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BuatTableProyekPekerjaanDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyek_pekerjaan_detail', function (Blueprint $table) {
            $table->unsignedInteger('proyek_pekerjaan_id');
            $table->unsignedInteger('proyek_pekerjaan_sebelumnya');
            $table->foreign('proyek_pekerjaan_id')
                ->references('id')
                ->on('proyek_pekerjaan')
                ->onDelete('cascade');
            $table->foreign('proyek_pekerjaan_sebelumnya')
                ->references('id')
                ->on('proyek_pekerjaan')
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
        Schema::dropIfExists('proyek_pekerjaan_detail');
    }
}
