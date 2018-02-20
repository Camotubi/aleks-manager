<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailsQueueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails_queue', function (Blueprint $table) {
            $table->increments('id');
            $table->string('student_id');
            $table->foreign('student_id')->references('id')->on('students');
            $table->string('email_type');
            $table->timestamp('created_at')->nullable();
            $table->tinyInteger('status')->unsigned()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emails_queue');
    }
}
