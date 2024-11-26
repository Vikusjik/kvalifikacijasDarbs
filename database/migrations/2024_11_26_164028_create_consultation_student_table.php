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
        Schema::create('consultation_student', function (Blueprint $table) {
            $table->string('topic')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->string('cancellation_reason')->nullable();
            $table->enum('status', ['gaida', 'apstiprināts', 'atcēlts'])->default('gaida');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultation_student');
    }
};
