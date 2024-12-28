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
            $table->timestamp('date_of_publication');
            $table->timestamp('date_of_writing');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
