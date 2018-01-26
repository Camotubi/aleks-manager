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
            $table->timestamps();
            $table->string('module_name');	
            $table->double('initial_mastery',8,2);
            $table->double('current_mastery',8,2);
            $table->double('current_number_of_topic_learned',8,2);
            $table->integer('current_total_number_of_topic_learned_per_hour');
            $table->time('current_total_time_spent_in_aleks',8,2);
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
