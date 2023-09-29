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
        Schema::create('storagedetailes', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');

            $table->id();
            $table->string('Disk_Technology')->nullable();
            $table->string('Disk_Size')->nullable();
            $table->string('Disk_Capacity')->nullable();
            $table->string('Disk_Speed')->nullable();
            $table->string('Disk_Cache')->nullable();
            $table->string('Disk_Interface')->nullable();
            $table->string('Best_Used_For')->nullable();
            
            //this is for flash driver
            $table->string('Flash_Capacity')->nullable();
            $table->string('Flash_Type')->nullable();
            $table->string('Interface')->nullable();
            $table->string('Compatible_with')->nullable();


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
        Schema::dropIfExists('storagedetailes');
    }
};
