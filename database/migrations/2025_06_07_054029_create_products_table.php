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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('description', 255)->nullable();
            $table->integer('quantity')->default(0);
            $table->float('cost_price')->default(0);
            $table->float('sale_price')->default(0);
            $table->string('image')->nullable();
            $table->boolean('active')->default(true);
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('supplier_id')->constrained('suppliers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    { 
        Schema::dropIfExists('images');
        Schema::dropIfExists('products');
    }
};
