<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('pass', 100);
            $table->string('image', 100)->nullable();
            $table->bigInteger('role_id')->unsigned()->default(2);
            $table->timestamps();

            $table->index('role_id');
            $table->foreign('role_id')->references('id')->on('roles');
        });

        DB::table('users')->insert([
            'name' => 'admin',
            'pass' => '$2y$10$0zzQK1Ly3OFIktLIMQvnJu6k96KAKPgAsB1lK.0I/sqQkQuZf0fSi',
            'role_id' => 1
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
