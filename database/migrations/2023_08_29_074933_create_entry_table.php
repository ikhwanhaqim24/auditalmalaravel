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
        Schema::create('entry', function (Blueprint $table) {
            $table->id();
            $table->string('details');
            $table->integer('amount');
            $table->unsignedBigInteger('category');
            $table->unsignedBigInteger('author_id')->nullable();
            $table->json('attachment')->nullable();
            $table->timestamps();
            $table->string('external_info')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entry');
    }
};
