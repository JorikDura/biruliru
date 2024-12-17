<?php

declare(strict_types=1);

use App\Enums\PersonRole;
use App\Models\Book;
use App\Models\Person;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('book_person', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Book::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Person::class)->constrained()->cascadeOnDelete();
            $table->enum('role', array_column(PersonRole::cases(), 'value'));
            $table->unique(['book_id', 'person_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_person');
    }
};
