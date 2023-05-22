<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuditlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auditlogs', function (Blueprint $table) {
            // $table->engine = 'InnoDB';
            $table->increments('auditid');
            $table->integer('userid');
            $table->integer('effectedid')->nullable();
            $table->text('activity');
            $table->string('ipaddress');
            $table->string('email')->nullable();
            $table->string('tablename')->nullable();
            $table->string('fieldname')->nullable();
            $table->string('accesstype')->nullable();
            $table->timestamp('logtime')->useCurrent();
            $table->text('browser');
            $table->string('category')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('auditlogs');
    }
}
