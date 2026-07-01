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
    Schema::create('votes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('story_id')->constrained()->onDelete('cascade'); // Kumokonekta sa stories table
        $table->char('choice', 1); // 'A' o 'B'
        $table->string('ip_address'); // Proteksyon laban sa spam voting
        $table->string('user_agent'); // Browser info ng bumoto
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
