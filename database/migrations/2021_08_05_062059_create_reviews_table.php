<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->integer("drive_id");
            $table->integer("ride_id");
            $table->text("ride_from");
            $table->text("ride_to");
            $table->text("ride_from_lat");
            $table->text("ride_from_lng");
            $table->text("ride_to_lat");
            $table->text("ride_to_lng");
            $table->text("ride_distance");
            $table->text("ride_duration");
            $table->text("ride_charges");
            $table->decimal("ratings", 4, 2)->default(0);
            $table->text("comment");
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
        Schema::dropIfExists('reviews');
    }
}
