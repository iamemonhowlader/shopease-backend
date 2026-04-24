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
            $table->string('sale_id')->unique(); 
            $table->string('branch');
            $table->date('sale_date');
            $table->string('product_name');
            $table->string('category')->nullable();
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('discount_pct', 5, 4); 
            $table->string('payment_method');
            $table->string('salesperson')->default('Unknown');
            $table->decimal('revenue', 12, 2)->storedAs('ROUND(unit_price * quantity * (1 - discount_pct), 2)'); 
            $table->timestamps();

            // Indexes for filtering performance
            $table->index('branch');
            $table->index('sale_date');
            $table->index('category');
            $table->index('payment_method');
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
