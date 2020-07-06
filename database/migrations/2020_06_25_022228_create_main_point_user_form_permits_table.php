<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMainPointUserFormPermitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('main_point_user_form_permits', function (Blueprint $table) {
            $table->id();
            $table->integer('total_point');
            $table->integer('evaluate_user_id');
            $table->integer('main_point_id');
            $table->unsignedBigInteger('form_id');
            $table->foreign('form_id')->references('form_id')->on('form_permits')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('main_point_user_form_permits');
    }
}
