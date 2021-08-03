<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRideAuthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ride_auths', function (Blueprint $table) {
            $table->id();
            $table->text("ride_first_name");
            $table->text("ride_last_name");
            $table->text("ride_password");
            $table->text("ride_gender");
            $table->text("ride_phone");
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
        Schema::dropIfExists('ride_auths');
    }
}
