<?php

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
            $table->increments('id');
            $table->string('username');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone');
            $table->tinyInteger('gender')->nullable();
            $table->date('dob')->nullable();            
            $table->boolean('active')->default(0);

            $table->boolean('pwd_changed')->default(0); 
            $table->timestamp('password_chng_date')->default(date("Y-m-d H:i:s"));
            $table->tinyInteger('loginattempts')->default(0);
            $table->string('invited_by')->default(0);

            $table->boolean('pay_active')->default(0); 
            $table->timestamp('pay_active_date')->nullable(); 
            $table->timestamp('pay_last_date')->nullable();               
            $table->tinyInteger('current_level')->default(0);

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
