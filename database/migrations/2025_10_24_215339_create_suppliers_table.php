<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact_email');
            $table->string('phone');
            $table->text('address');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('suppliers');
    }
};