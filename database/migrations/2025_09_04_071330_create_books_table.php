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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('book_cover')->default('not available');; // store image path, 'not available' if not always provided
            $table->string('title')->default('unknown');;
            $table->string('author')->default('unknown');;
            $table->integer('published_year')->nullable();
            $table->string('genre');
            $table->string('pdf_file');
            $table->timestamp('uploaded_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
