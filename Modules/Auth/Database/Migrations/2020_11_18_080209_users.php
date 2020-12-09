<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Users extends Migration
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
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->unique();
            $table->string('password')->nullable();
            $table->string('gender')->nullable();
            $table->string('mobile_verify_code')->nullable();
            $table->boolean('mobile_verify')->default(false);
            /*Patient*/
            $table->string("dossier_number")->nullable();
            $table->string("birthday")->nullable();
            $table->string("age")->nullable();
            $table->string("height")->nullable();
            $table->string("weight")->nullable();
            $table->string("address")->nullable();
            /*Doctor*/
            $table->unsignedBigInteger("degree_id")->nullable();
//            $table->foreign('degree_id')->references('id')->on('doctor_degrees')->onDelete('cascade');
            $table->softDeletesTz('deleted_at', 0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
