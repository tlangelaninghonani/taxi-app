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
            $table->boolean("on_trip")->default(false);
            $table->integer("on_trip_drive_id")->default(0);
            $table->text("ride_from")->nullable();
            $table->text("ride_to")->nullable();
            $table->boolean("drive_accepted")->default(false);
            $table->text("drive_requests")->default("[]");
            $table->text("drive_offers")->default("[]");
            $table->integer("ride_later_track")->default(1);
            $table->integer("ride_offer_track")->default(1);
            $table->text("ride_plans")->default("[]");
            $table->boolean("riding_later")->default(false);
            $table->text("trip_charge")->default("[]");
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
