<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->text('comment')->nullable();
            $table->string('status')->default('new'); // new, processing, completed, cancelled
            $table->json('items'); // [{product_id, variant_id, size, quantity, price}]
            $table->decimal('total', 10, 2)->default(0);
            $table->string('locale', 5)->default('ru');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
