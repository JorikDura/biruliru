<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('descriptions', function (Blueprint $table) {
            $table->id();
            $table->morphs('descriptionable');
            $table->string('language');
            $table->text('text');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('descriptions');
    }
};
