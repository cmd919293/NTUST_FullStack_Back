<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class MakeRelationShipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('MonsterAttributes', function (Blueprint $table) {
            $table->foreign('MonsterId')->references('id')->on('Monsters')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('AttributeId')->references('id')->on('AttributeName')->onDelete('cascade')->onUpdate('cascade');
        });
        Schema::table('MonsterName', function (Blueprint $table) {
            $table->foreign('id')->references('id')->on('Monsters')->onDelete('cascade')->onUpdate('cascade');
        });
        Schema::table('Order', function (Blueprint $table) {
            $table->foreign('UserId')->references('id')->on('Users')->onDelete('cascade')->onUpdate('cascade');
        });
        Schema::table('OrderItem', function (Blueprint $table) {
            $table->foreign('OrderId')->references('id')->on('Order')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('ProductId')->references('id')->on('Monsters')->onDelete('cascade')->onUpdate('cascade');
        });
        Schema::table('Cart', function (Blueprint $table) {
            $table->foreign('UserId')->references('id')->on('Users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('ProductId')->references('id')->on('Monsters')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('MonsterAttributes', function (Blueprint $table) {
            foreach (['MonsterId', 'AttributeId'] as $key)
                $table->dropForeign([$key]);
        });
        Schema::table('MonsterName', function (Blueprint $table) {
            foreach (['id'] as $key)
                $table->dropForeign([$key]);
        });
        Schema::table('Order', function (Blueprint $table) {
            foreach (['UserId'] as $key)
                $table->dropForeign([$key]);
        });
        Schema::table('OrderItem', function (Blueprint $table) {
            foreach (['OrderId', 'ProductId'] as $key)
                $table->dropForeign([$key]);
        });
        Schema::table('Cart', function (Blueprint $table) {
            foreach (['ProductId', 'UserId'] as $key)
                $table->dropForeign([$key]);
        });
    }
}
