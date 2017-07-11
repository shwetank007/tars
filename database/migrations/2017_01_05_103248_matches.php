<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Matches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('hero_id')
                ->nullable();
            $table->foreign('hero_id')
                ->references('id')
                ->on('heroes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedInteger('villain_id')
                ->nullable();
            $table->foreign('villain_id')
                ->references('id')
                ->on('villains')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('cause');
            $table->string('place');
            $table->string('date');
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
        Schema::drop('matches');
    }
}
