<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Powers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('powers', function (Blueprint $table) {
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
            $table->string('power_name');
            $table->string('damage');
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
        Schema::drop('powers');
    }
}
