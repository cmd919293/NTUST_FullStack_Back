<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMonsterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monsters', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('imgNum');
            $table->integer('HP');
            $table->integer('ATTACK');
            $table->integer('DEFENSE');
            $table->integer('SP_ATTACK');
            $table->integer('SP_DEFENSE');
            $table->integer('SPEED');
            $table->integer('sold');
            $table->integer('discount')->default(100);
            $table->integer('price');
            $table->text('description');
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
        Schema::dropIfExists('monsters');
    }
}
