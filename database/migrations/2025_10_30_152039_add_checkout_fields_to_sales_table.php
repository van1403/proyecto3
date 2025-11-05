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
       Schema::table('sales', function (Blueprint $table) {
        $table->string('delivery_method')->nullable(); // envio o retiro
        $table->string('address')->nullable();
        $table->string('payment_method')->nullable(); // tarjeta, yape, efectivo
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('sales', function (Blueprint $table) {
        $table->dropColumn(['delivery_method', 'address', 'payment_method']);
    });
    }
};
