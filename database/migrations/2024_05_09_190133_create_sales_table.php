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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable()->max(300);
            $table->integer('quantity');
            $table->decimal('total_price', 10, 2);
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('retail_outlet_id')->constrained('retail_outlets')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
