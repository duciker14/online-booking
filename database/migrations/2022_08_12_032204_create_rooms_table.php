<?php

use App\Enums\RoomStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hotel_id');
            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');
            $table->unsignedBigInteger('room_type_id')->nullable();
            $table->foreign('room_type_id')->references('id')->on('room_type')->onDelete('cascade');
            $table->string('name');
            $table->string('background')->nullable();
            $table->text('description')->nullable();
            $table->json('img')->nullable();
            $table->double('price');
            $table->tinyInteger('status')->default(RoomStatus::AVAILABLE);
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
        Schema::dropIfExists('rooms');
    }
}
