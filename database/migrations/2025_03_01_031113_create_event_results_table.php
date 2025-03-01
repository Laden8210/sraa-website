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
        Schema::create('event_results', function (Blueprint $table) {
            $table->id('result_id'); 
            $table->string('event_name'); 
            $table->enum('medal_type', ['Gold', 'Silver', 'Bronze']); 
            $table->string('winner_name'); 
            $table->string('division'); 
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_results');
    }
};
