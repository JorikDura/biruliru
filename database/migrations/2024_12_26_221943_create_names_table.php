<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('names', function (Blueprint $table) {
            $table->id();
            $table->morphs('nameable');
            $table->string('name');
        });

        DB::statement(
            "ALTER TABLE names
                ADD COLUMN language regconfig,
                ADD COLUMN vector_name tsvector GENERATED ALWAYS AS (to_tsvector(language, name)) STORED;"
        );

        DB::statement("CREATE INDEX IF NOT EXISTS names_vector_name_gin_index ON names USING GIN (vector_name);");
    }

    public function down(): void
    {
        DB::statement("DROP INDEX IF EXISTS names_vector_name_gin_index;");
        Schema::dropIfExists('names');
    }
};
