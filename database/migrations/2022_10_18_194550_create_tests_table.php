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
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('post_id')->unsigned();
            $table->string('text', 500);
            $table->string('right', 100);
            $table->bigInteger('type_id')->unsigned();
            $table->string('ans1', 50)->nullable();
            $table->string('ans2', 50)->nullable();
            $table->string('ans3', 50)->nullable();
            $table->string('ans4', 50)->nullable();
            $table->timestamps();

            $table->index('post_id');
            $table->foreign('post_id')->references('id')->on('posts');

            $table->index('type_id');
            $table->foreign('type_id')->references('id')->on('types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tests');
    }
};
