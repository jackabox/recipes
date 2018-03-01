<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug');
            $table->longText('description')->nullable(true);
            $table->integer('user_id')->unsigned()->nullable(true);
            $table->mediumInteger('serves');
            $table->mediumInteger('cook_time');
            $table->mediumInteger('prep_time');
            $table->json('ingredients');
            $table->json('method');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipes');
    }
}
