<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->unsignedBigInteger('scheduling_id');
            $table->decimal('price', 15, 0)->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index('booking_id');
            $table->index('scheduling_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_items');
    }
};