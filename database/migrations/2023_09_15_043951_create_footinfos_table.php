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
        Schema::create('footinfos', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('address');
            $table->string('numberOne')->nullable();
            $table->string('numberTwo')->nullable();
            $table->string('numberThree')->nullable();
            $table->string('description');
            $table->string('faceBook_Account');
            $table->string('instagram_Account');
            $table->string('twitter_Account');
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
        Schema::dropIfExists('footinfos');
    }
};
