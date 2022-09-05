<?php

use App\Enums\UserRole;
use App\Enums\UserStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->tinyInteger('role')->default(UserRole::TOURIST);
            $table->string('phone', 50)->nullable();
            $table->string('address')->nullable();
            $table->tinyInteger('gender')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('avatar')->nullable();
            $table->tinyInteger('is_affiliator')->nullable();
            $table->string('referen_url')->nullable();
            $table->unsignedBigInteger('affiliator_ref')->nullable();
            $table->double('money')->nullable();
            $table->tinyInteger('status')->default(UserStatus::DISABLED);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('google_id', 50)->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
