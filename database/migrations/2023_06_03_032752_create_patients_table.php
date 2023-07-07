<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->integer('age');
            $table->string('email')->nullable();
            $table->string('location');
            $table->string('discharge_date');
            $table->string('device_id')->nullable();
            $table->string('vital_signs')->nullable();
            $table->string('medication')->nullable();
            $table->string('allergies')->nullable();
            $table->string('emergency_contacts')->nullable();
            $table->string('medical_notes')->nullable();
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
        Schema::dropIfExists('patients');
    }
}
