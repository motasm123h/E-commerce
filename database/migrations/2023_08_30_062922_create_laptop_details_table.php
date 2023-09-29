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
        Schema::create('laptop_details', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            
            $table->id();
            $table->string('Processor_Generation');
            $table->string('Processor_Family');
            $table->string('Processor_Speed');
            $table->string('Processor_Cash');
            $table->string('Number_Of_Coures');
            $table->string('Ram_Capacity');
            $table->string('Memory_Type');
            $table->string('Storage_Capacity');
            $table->string('Storage_Type');
            $table->string('Graphic_Manufacturer');
            $table->string('Graphic_Model');
            $table->string('Graphic_Memory_Source');
            $table->string('Display_Size');
            $table->string('Displa_Technology');
            $table->string('Display_Resolution');
            $table->string('Keyboard');
            $table->string('Keyboard_Backlight');
            $table->string('Ports');
            $table->string('Optical_Drive');
            $table->string('Camera')->nullable();
            $table->string('Audio')->nullable();
            $table->string('Networking');
            $table->string('Battery_Number_Of_Cells');
            $table->string('Operation_System');
            $table->string('multiMedia')->nullable();
            $table->string('Case_Model')->nullable();
            $table->string('Light_Type')->nullable();
            $table->string('Power_Supply')->nullable();
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
        Schema::dropIfExists('laptop_details');
    }
};
