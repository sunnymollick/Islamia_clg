<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bill_id');
            $table->unsignedBigInteger('income_head_id');
            $table->double('payable');
            $table->double('discount')->nullable();
            $table->boolean('is_paid')->nullable();
            $table->foreign('bill_id')->references('id')->on('bills')
                ->onDelete('cascade')->onUpdate('cascade');    
            $table->foreign('income_head_id')->references('id')->on('income_heads')
                ->onDelete('cascade')->onUpdate('cascade');    
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
        Schema::dropIfExists('bill_details');
    }
}
