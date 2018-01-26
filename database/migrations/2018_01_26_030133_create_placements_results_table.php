<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlacementsResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('placements_results', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('student_id');
            $table->foreign('student_id')->references('id')->on('users');
            $table->integer('placement_assestment_number');
            $table->integer('total_number_of_placements_taken');
            $table->date('start_date');
            $table->time('start_time');
            $table->date('end_date');
            $table->time('end_time');
            $table->string('proctored_assestment');
            $table->time('time_in_placements');
            $table->double('placement_result',8,2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('placements_results');
    }
}
