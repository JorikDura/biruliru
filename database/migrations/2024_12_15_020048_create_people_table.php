<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date_of_birth')->nullable();
            $table->timestamp('date_of_death')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
