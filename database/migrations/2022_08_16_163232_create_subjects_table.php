<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('std_class_id')->nullable()->unsigned();
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->string('order')->nullable();
            $table->double('marks')->nullable();
            $table->double('pass_marks')->nullable();
            $table->double('theory_marks')->nullable();
            $table->double('theory_pass_marks')->nullable();
            $table->double('mcq_marks')->nullable();
            $table->double('mcq_pass_marks')->nullable();
            $table->double('practical_marks')->nullable();
            $table->double('practical_pass_marks')->nullable();
            $table->double('ct_marks')->nullable();
            $table->double('ct_pass_marks')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->integer('uploaded_by')->nullable();
            $table->timestamps();

            $table->foreign('std_class_id')
                ->references('id')
                ->on('std_classes')
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
        Schema::dropIfExists('subjects');
    }
}
