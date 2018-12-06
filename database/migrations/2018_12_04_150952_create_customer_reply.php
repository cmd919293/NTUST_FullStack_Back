<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerReply extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CustomerReply', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('userID');
            $table->unsignedInteger('imageNum');
            $table->boolean('resolved');
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
        Storage::deleteDirectory('app/customer-reply');
        Schema::dropIfExists('CustomerReply');
    }
}
