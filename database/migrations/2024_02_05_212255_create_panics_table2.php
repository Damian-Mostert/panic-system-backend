<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePanicsTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('panics', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('active');
            $table->string('type')->default('none'); // Added 'type' column
            $table->string('details')->default(' '); // Changed 'details' to text
            $table->double('longitude')->default(0.0); // Changed 'longitude' to double
            $table->double('latitude')->default(0.0); // Changed 'latitude' to double
            $table->boolean('canceled')->default(false);
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
        Schema::dropIfExists('panics');
    }
}
