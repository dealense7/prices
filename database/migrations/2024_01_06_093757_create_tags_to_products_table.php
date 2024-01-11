<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tags_to_products', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('tag_id')->constrained('tags');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tags_to_products');
    }
};
