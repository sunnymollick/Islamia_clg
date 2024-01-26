<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStdClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('std_classes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('session_id')->nullable()->unsigned();
            $table->string('name')->nullable();
            $table->string('in_digit')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->integer('uploaded_by')->nullable();
            $table->timestamps();

            $table->foreign('session_id')
                ->references('id')
                ->on('sessions')
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
        Schema::dropIfExists('std_classes');
    }
}
