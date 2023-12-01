<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('appointment_code')->nullable(false)->unique();
            $table->string('patient_name')->nullable(false);
            $table->string('patient_phone_number')->nullable(false);
            $table->string('patient_address')->nullable(false);
            $table->date('appointment_date')->nullable(false);
            $table->time('appointment_time')->nullable(false);
            $table->enum('status', ['Waiting', 'Missing', 'Completed'])->default('Waiting');
            $table->enum('type_appointment', ['BPJS', 'Umum','Mandiri', 'Asuransi']);
            $table->string('no_queue');
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->unsignedBigInteger('doctor_id')->nullable(false);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('doctor_id')->references('id')->on('doctors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
