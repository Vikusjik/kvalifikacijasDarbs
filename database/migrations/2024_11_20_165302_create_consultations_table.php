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
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();  // Šī kolonna pievieno automātiski palielināmo ID
            $table->timestamp('date_time')->nullable(); // Pievieno date_time kolonnu
            $table->timestamps(); // Šī pievieno created_at un updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};


   

