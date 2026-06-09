<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('buyer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('key');
            $table->enum('status', ['available', 'sold', 'used', 'expired'])->default('available');
            $table->timestamp('sold_at')->nullable();
            $table->timestamp('used_at')->nullable();
            $table->timestamps();

            $table->index('product_id');
            $table->index('status');
            $table->index('buyer_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('licenses');
    }
};
