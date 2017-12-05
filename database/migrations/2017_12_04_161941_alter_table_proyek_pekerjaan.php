<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableProyekPekerjaan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proyek_pekerjaan', function (Blueprint $table) {
            $table->string('pekerjaan_sebelumnya')->nullable();

            // $table->foreign('pekerjaan_sebelumnya')
            //   ->references('id')
            //   ->on('proyek_pekerjaan')
            //   ->onDelete('cascade');

            $table->dropColumn('bobot');
            $table->dropColumn('jumlah_minggu');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proyek_pekerjaan', function (Blueprint $table) {
            $table->float('bobot', 5, 2);
            $table->tinyInteger('jumlah_minggu');
            // $table->dropForeign('proyek_pekerjaan_pekerjaan_sebelumnya_foreign');
            // $table->dropColumn('pekerjaan_sebelumnya');
        });
    }
}
