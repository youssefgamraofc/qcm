<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHighscoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('highscores', function (Blueprint $table) {
          $table->increments('id');
          $table->string('user_name');
          $table->string('email')->default('0');
          $table->integer('type_id');
          $table->integer('score');
          $table->tinyInteger('number_of_questions');
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
        //
    }
}
