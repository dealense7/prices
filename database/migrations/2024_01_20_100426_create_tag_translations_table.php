<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tag_translations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('language_id')->constrained('languages');
            $table->foreignId('tag_id')->constrained('tags');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tag_translations');
    }
};
