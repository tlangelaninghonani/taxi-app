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
            $table->decimal("ride_balance", 10, 2)->default(0.00);

            $table->boolean("ride_on_trip")->default(false);
            $table->integer("ride_on_trip_drive_id")->default(0);
            $table->text("ride_on_trip_from")->nullable();
            $table->text("ride_on_trip_to")->nullable();
            $table->text("ride_on_trip_lat")->nullable();
            $table->text("ride_on_trip_lng")->nullable();
            $table->text("ride_on_trip_distance")->nullable();
            $table->text("ride_on_trip_time")->nullable();
            $table->text("ride_on_trip_charges")->nullable();

            $table->text("ride_requests")->default("[]");

            $table->text("ride_offers")->default("[]");

            $table->integer("ride_plans")->default("[]");

            $table->text("ride_history_drive_id")->default("[]");
            
            $table->boolean("pick_up_requested")->default(false);
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
