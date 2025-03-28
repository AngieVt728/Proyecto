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
        Schema::create('retail_outlets', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('nit', 20);
            $table->string('image_url', 255)->nullable();
            $table->string('address', 255);
            $table->decimal('lat', 20, 15);
            $table->decimal('lng', 20, 15);
            $table->text('description')->nullable()->max(300);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retail_outlets');
    }
};
