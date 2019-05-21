<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookedWorkshopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booked_workshops', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('workshop_id')->unsigned();
            $table->bigInteger('leader_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('booked_workshops', function (Blueprint $table) {
            $table->foreign('workshop_id')
                ->references('id')
                ->on('workshops')
                ->onDelete('cascade');
            $table->foreign('leader_id')
                ->references('id')
                ->on('users')
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
        Schema::table('booked_workshops', function (Blueprint $table) {
            $table->dropForeign(['workshop_id']);
            $table->dropForeign(['leader_id']);
        });

        Schema::dropIfExists('booked_workshops');
    }
}
