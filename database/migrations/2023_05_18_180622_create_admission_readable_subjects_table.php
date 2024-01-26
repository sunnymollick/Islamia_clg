<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmissionReadableSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admission_readable_subjects', function (Blueprint $table) {
            $table->id();
            $table->string('sub_name');
            $table->string('sub_code');
            $table->unsignedBigInteger('admission_id');
            $table->foreign('admission_id')
                ->references('id')
                ->on('admission_applications')
                ->onDelete('cascade');
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
        Schema::dropIfExists('admission_readable_subjects');
    }
}
