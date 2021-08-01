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
            $table->text("ride_trip")->nullable();
            $table->boolean("ride_on_trip")->default(false);
            $table->text("ride_requests")->default("[]");
            $table->text("ride_offers")->default("[]");
            $table->text("ride_plans")->default("[]");
            $table->text("ride_history")->default("[]");
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
