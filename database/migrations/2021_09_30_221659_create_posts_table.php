<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('autor');
            $table->string('tipo');
            $table->string('titulo');
            $table->text('content')->nullable();
            $table->string('slug')->nullable();
            $table->string('tags')->nullable();
            $table->bigInteger('views')->default(0);
            $table->unsignedInteger('categoria');
            $table->integer('cat_pai')->nullable();
            $table->integer('comentarios')->nullable();
            $table->integer('status')->nullable();
            $table->string('thumb_legenda')->nullable(); 
            $table->date('publish_at')->nullable();

            $table->timestamps();

            $table->foreign('autor')->references('id')->on('users')->onDelete('CASCADE');
            $table->foreign('categoria')->references('id')->on('cat_post')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
