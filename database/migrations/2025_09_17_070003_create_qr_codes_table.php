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
        Schema::create('qr_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('uid', 6)->unique();
            $table->string('pin', 4);
            $table->boolean('status')->default(false);

            // profile type restriction
            $table->enum('profile_type', ['Human', 'Pet', 'Valuables'])->default('Human');

            // optional: link QR to profile
            $table->foreignId('profile_id')->nullable()->constrained()->cascadeOnDelete();

            // link to batch
            $table->foreignId('batch_id')->nullable()->constrained('qr_batches')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qr_codes');
    }
};
