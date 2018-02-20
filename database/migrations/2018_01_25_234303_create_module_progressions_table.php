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
            $table->timestamps();
            $table->string('student_id');
            $table->foreign('student_id')->references('id')->on('students');
            $table->string('prep_and_learning_module');
            $table->decimal('initial_mastery',18,13);
            $table->decimal('current_mastery',18,13);
            $table->integer('current_number_of_topics_learned')->unsigned();
            $table->decimal('current_number_of_topics_learned_per_hour',18,13)->nullable();
            $table->decimal('current_total_hours_in_aleks_prep',18,13)->unsigned();
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
