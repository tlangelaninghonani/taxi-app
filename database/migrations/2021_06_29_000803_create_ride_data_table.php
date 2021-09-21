<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRideDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ride_data', function (Blueprint $table) {
            $table->id();
            $table->integer("ride_id");
            $table->text("ride_profile_image")->nullable();
            $table->boolean("ride_on_trip")->default(false);
            $table->decimal("ride_promo")->default(20);
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
        Schema::dropIfExists('ride_data');
    }
}
