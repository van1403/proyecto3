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
         Schema::create('shippings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('sale_id')->constrained()->onDelete('cascade');
        $table->enum('delivery_type', ['Envío', 'Retiro']);
        $table->string('address')->nullable();
        $table->string('city')->nullable();
        $table->string('region')->nullable();
        $table->string('postal_code')->nullable();
        $table->string('phone')->nullable();
        $table->decimal('shipping_cost', 8, 2)->default(0);
        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shippings');
    }
};
