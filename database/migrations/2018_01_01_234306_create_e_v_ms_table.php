<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEVMsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evm', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('minggu_ke');
            $table->decimal('bcws_bobot', 5,2);
            $table->integer('bcws_budget');
            $table->decimal('bcwp_bobot', 5,2)->nullable();
            $table->integer('bcwp_budget')->nullable();
            $table->integer('acwp_budget')->nullable();
            $table->boolean('status')->default(0);
            $table->timestamps();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('proyek_id');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
            $table->foreign('proyek_id')
                ->references('id')
                ->on('proyek')
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
        Schema::dropIfExists('evm');
    }
}
