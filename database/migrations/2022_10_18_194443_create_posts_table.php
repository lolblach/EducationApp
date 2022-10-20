<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->text('content', 100000);
            $table->bigInteger('tag_id')->unsigned();
            $table->bigInteger('creator_id')->unsigned();
            $table->timestamps();

            $table->index('tag_id');
            $table->foreign('tag_id')->references('id')->on('tags');
            
            $table->index('creator_id');
            $table->foreign('creator_id')->references('id')->on('users');
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
};
