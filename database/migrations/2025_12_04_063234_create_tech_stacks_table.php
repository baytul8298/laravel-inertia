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
        Schema::create('tech_stacks', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('title', 255);
            $table->string('description', 255)->nullable();
            $table->string('slug', 255)->nullable();;
            $table->string('image', 255)->nullable();;
            $table->string('sort', 10)->nullable();;
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tech_stacks');
    }
};
