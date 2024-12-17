<?php

declare(strict_types=1);

use App\Enums\PersonRole;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('english_name');
            $table->string('russian_name');
            $table->string('original_name');
            $table->timestamp('date_of_birth')->nullable();
            $table->timestamp('date_of_death')->nullable();
            //$table->enum('role', array_column(PersonRole::cases(), 'value'));
            $table->text('english_description')->nullable();
            $table->text('russian_description')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
