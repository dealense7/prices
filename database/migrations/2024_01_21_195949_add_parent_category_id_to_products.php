<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('product_to_categories', function (Blueprint $table) {
            $table->foreignId('parent_category_id')->nullable()->constrained('categories');
        });
    }

    public function down(): void
    {
        Schema::table('product_to_categories', function (Blueprint $table) {
            $table->dropForeign(['parent_category_id']);
            $table->dropColumn(['parent_category_id']);
        });
    }
};
