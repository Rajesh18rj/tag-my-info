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
        Schema::table('qr_batches', function (Blueprint $table) {
            $table->integer('batch_no')->nullable()->after('count');
            $table->string('profile_type')->nullable()->after('batch_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('qr_batches', function (Blueprint $table) {
            $table->dropColumn(['batch_no', 'profile_type']);

        });
    }
};
