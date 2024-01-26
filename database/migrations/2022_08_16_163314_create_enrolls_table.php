<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrolls', function (Blueprint $table) {
            $table->increments('id');
            $table->string('student_code')->nullable();
            $table->integer('student_id')->nullable();
            $table->integer('class_id')->nullable();
            $table->integer('subject_id')->nullable();
            $table->integer('section_id')->nullable()->unsigned();
            $table->integer('optional_subject_id')->nullable()->unsigned();
            $table->integer('roll')->nullable();
            $table->string('year')->nullable();
            $table->date('date_added')->nullable();
            $table->string('name')->nullable();

            $table->tinyInteger('status')->default(1);
            $table->integer('uploaded_by')->nullable();
            $table->timestamps();

            $table->foreign('student_code')
                ->references('code')
                ->on('students')
                ->onDelete('cascade');
            $table->foreign('section_id')
                ->references('id')
                ->on('sections')
                ->onDelete('cascade');
            $table->foreign('optional_subject_id')
                ->references('id')
                ->on('subjects')
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
        Schema::dropIfExists('enrolls');
    }
}
