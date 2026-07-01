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
    Schema::create('stories', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('slug')->unique(); // Para sa magandang URL (e.g., sinoangmali.test/kwento/panganay-vs-bunso)
        $table->text('content'); // Dito ilalagay ang kwento para basahin ng AdSense
        $table->string('option_a'); // Halimbawa: "Kakampi sa Asawa"
        $table->string('option_b'); // Halimbawa: "Kakampi sa Ina"
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stories');
    }
};
