<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEducationalFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('educational_fees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('income_head_id');
            $table->integer('std_class_id')->unsigned();
            // $table->integer('section_id')->unsigned();
            $table->double('amount');
            $table->foreign('income_head_id')->references('id')->on('income_heads')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('std_class_id')->references('id')->on('std_classes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
                
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
        Schema::dropIfExists('educational_fees');
    }
}
