<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pending_chat_ids', function (Blueprint $table) {
            $table->id();
            $table->string('phone', 20);
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            $table->index('phone');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pending_chat_ids');
    }
};