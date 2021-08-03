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
            $table->text("drive_vehicle_plate");
            $table->text("drive_vehicle_color");
            $table->text("drive_reviews")->default("[]");
            $table->decimal("drive_ratings", 4, 2)->default(0.0);
            $table->text("ride_offers")->default("[]");
            $table->text("drive_trip")->nullable();
            $table->boolean("drive_on_trip")->default(false);
            $table->text("drive_history")->default("[]");
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
