<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subject_assign_id')->nullable()->unsigned();
            $table->string('student_code')->nullable();
            $table->integer('exam_id')->nullable()->unsigned();
            $table->double('theory_marks')->nullable();
            $table->double('mcq_marks')->nullable();
            $table->double('practical_marks')->nullable();
            $table->double('ct_marks')->nullable();
            $table->double('total_marks')->nullable();
            $table->tinyInteger('pass_status')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->integer('uploaded_by')->nullable();
            $table->timestamps();

            $table->foreign('subject_assign_id')
                ->references('id')
                ->on('subject_assigns')
                ->onDelete('cascade');
            $table->foreign('student_code')
                ->references('student_code')
                ->on('enrolls')
                ->onDelete('cascade');
            $table->foreign('exam_id')
                ->references('id')
                ->on('exams')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marks');
    }
}
