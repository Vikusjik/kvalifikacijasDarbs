<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
        Schema::table('consultations', function (Blueprint $table) {
        $table->unsignedBigInteger('created_by')->nullable(); //Skolotāju ID 
        $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade'); // Saistiba ar useru tabulu  
        });
}

public function down()
{
        Schema::table('consultations', function (Blueprint $table) {
        $table->dropForeign(['created_by']);
        $table->dropColumn('created_by');
    });
}
};
