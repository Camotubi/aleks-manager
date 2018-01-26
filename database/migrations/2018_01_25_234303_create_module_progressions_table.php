<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModuleProgressionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_progressions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('student_id');
            $table->foreign('student_id')->references('id')->on('users');
            $table->date('recorded_at');
            $table->date('last_login');
            $table->timestamps();
            $table->integer('module_name');	
            $table->integer('initial_mastery');
            $table->integer('current_mastery');
            $table->integer('current_number_of_topic_learned');
            $table->integer('current_total_number_of_topic_learned_per_hour');
            $table->integer('current_total_time_spent_in_aleks');
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('module_progressions');
    }
}
