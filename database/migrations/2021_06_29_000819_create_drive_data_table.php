<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriveDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drive_data', function (Blueprint $table) {
            $table->id();
            $table->integer("drive_id");
            $table->text("drive_profile_image")->nullable();
            $table->text("drive_vehicle");
            $table->text("drive_vehicle_type");
            $table->decimal("drive_ratings", 1, 1)->default(0.0);
            $table->text("ride_requests")->default("[]");
            $table->text("ride_offers")->default("[]");
            $table->boolean("on_trip")->default(false);
            $table->integer("on_trip_ride_id")->default(0);
            $table->text("ride_from")->nullable();
            $table->text("ride_to")->nullable();
            $table->boolean("ride_accepted")->default(false);
            $table->text("trip_charge")->default("[]");
            $table->text("drive_history_ride_id")->default("[]");
            $table->boolean("confirm_pickup")->default(false);
            
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
        Schema::dropIfExists('drive_data');
    }
}
