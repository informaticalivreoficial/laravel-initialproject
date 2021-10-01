<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_post', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_pai')->unsigned()->nullable();
            $table->string('titulo');
            $table->text('content')->nullable();
            $table->string('slug')->nullable();
            $table->string('tags')->nullable();
            $table->bigInteger('views')->default(0);
            $table->string('tipo')->nullable();
            $table->integer('status')->nullable();
            
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
        Schema::dropIfExists('cat_post');
    }
}
