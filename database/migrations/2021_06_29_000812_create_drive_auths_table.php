<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriveAuthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drive_auths', function (Blueprint $table) {
            $table->id();
            $table->text("drive_first_name");
            $table->text("drive_last_name");
            $table->text("drive_password");
            $table->text("drive_gender");
            $table->text("drive_phone");
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
        Schema::dropIfExists('drive_auths');
    }
}
