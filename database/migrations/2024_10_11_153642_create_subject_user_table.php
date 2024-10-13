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
        Schema::create('subject_user', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('ic')->constrained('users')->onDelete('cascade'); // Foreign key referencing users
            $table->string('subject_code'); // Assuming subject_code is a string
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subject_user');
    }
};
