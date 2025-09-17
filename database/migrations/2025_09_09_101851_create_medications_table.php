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
        Schema::create('medications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profile_id');
            $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('cascade');
            $table->string('medication_name');
            $table->text('notes')->nullable();
            $table->string('dosage')->nullable();
            $table->enum('dosage_unit', ['pills', 'cc', 'ml', 'gr', 'mg', 'units', 'spray', 'etc'])->nullable();
            $table->enum('frequency', ['daily', 'weekly', 'monthly', 'as needed'])->nullable();
            $table->enum('frequency_type', ['1time', '2times', '3times', '4times'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medications');
    }
};
