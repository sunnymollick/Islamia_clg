<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('std_class_id')->nullable()->unsigned();
            $table->string('name')->nullable();
            $table->integer('identification_number')->nullable();
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
        Schema::dropIfExists('sections');
    }
}
