<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShoppingListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopping_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('recipe_id')->unsigned();
            $table->bigInteger('quantity');
            $table->string('measurement', 10)->nullable(true);
            $table->string('ingredient');
            $table->boolean('bought');
            $table->timestamp('expires_on')->nullable(true);
            $table->timestamps();

            $table->foreign('recipe_id')->references('id')->on('recipes');
            $table->foreign('user_id')->references('id')->on('users');
            $table->index(['ingredient', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shopping_lists');
    }
}
