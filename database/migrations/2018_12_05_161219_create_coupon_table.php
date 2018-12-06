<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Name');
            $table->unsignedInteger('UserId');
            $table->unsignedInteger('OrderId');
            $table->unsignedInteger('Discount');
            $table->string('Token');
            $table->dateTime('expired_at');
            $table->boolean('Owned');
            $table->boolean('Used');
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
        Schema::dropIfExists('coupon');
    }
}
