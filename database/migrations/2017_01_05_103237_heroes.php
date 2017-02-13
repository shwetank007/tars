<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Heroes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('heroes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('avatar');
            $table->string('actor');
            $table->string('name');
            $table->unique(['actor','name']);
            $table->string('partner');
            $table->string('rival');
            $table->boolean('detail');
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
        Schema::drop('heroes');
    }
}
