<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('english_name');
            $table->string('russian_name');
            $table->string('original_name');
            $table->timestamp('date_of_publication');
            $table->timestamp('date_of_writing');
            $table->text('english_description')->nullable();
            $table->text('russian_description')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};