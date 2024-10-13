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
        Schema::create('class_teacher', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ic');  // Foreign key to teachers table
            $table->unsignedBigInteger('classCode');    // Foreign key to classes table
            $table->integer('year');                   // Additional column for year
            $table->string('subjectCode');            // Additional column for subject code
            $table->timestamps();

            // Define foreign keys
            $table->foreign('ic')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('classCode')->references('id')->on('myclasses')->onDelete('cascade');

            // Composite unique key (optional)
            $table->unique(['ic', 'classCode', 'year', 'subjectCode']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_teacher');
    }
};
