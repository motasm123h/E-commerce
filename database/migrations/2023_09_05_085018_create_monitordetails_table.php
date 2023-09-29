<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monitordetails', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');

            $table->id();
            $table->string('Display_Size');
            $table->string('Displa_Technology');
            $table->string('Display_Resolution');
            $table->string('Contrast_Ratio')->nullable();
            $table->string('Response_Time')->nullable();
            $table->string('Signal_Frequency')->nullable();
            $table->string('Multimedia_Speakers')->nullable();
            $table->string('Ports');
            $table->string('Warranty');
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monitordetails');
    }
};
