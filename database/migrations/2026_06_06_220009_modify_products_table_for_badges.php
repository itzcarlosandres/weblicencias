<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['badge_text', 'badge_color', 'badge_icon']);
            $table->foreignId('badge_id')->nullable()->after('is_bestseller')->constrained('badges')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['badge_id']);
            $table->dropColumn('badge_id');
            $table->string('badge_text')->nullable()->after('is_bestseller');
            $table->string('badge_color')->nullable()->after('badge_text');
            $table->string('badge_icon')->nullable()->after('badge_color');
        });
    }
};
