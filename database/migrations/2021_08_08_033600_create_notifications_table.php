<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->integer("drive_id");
            $table->integer("ride_id");
            $table->integer("drive_ride_request")->default(0);
            $table->integer("drive_ride_plans")->default(0);
            $table->integer("drive_chat")->default(0);
            $table->integer("drive_ride_view")->default(0);
            $table->integer("drive_ride_history")->default(0);

            $table->integer("ride_request_accepted")->default(0);
            $table->integer("ride_offer")->default(0);
            $table->integer("ride_chat")->default(0);
            $table->integer("ride_drive_history")->default(0);
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
        Schema::dropIfExists('notifications');
    }
}
