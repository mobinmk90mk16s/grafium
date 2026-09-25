<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('scheduling', 'booking_id')) {
            Schema::table('scheduling', function (Blueprint $table) {
                $table->unsignedBigInteger('booking_id')->nullable()->after('reservation_id');
                $table->index('booking_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('scheduling', 'booking_id')) {
            Schema::table('scheduling', function (Blueprint $table) {
                $table->dropIndex(['booking_id']);
                $table->dropColumn('booking_id');
            });
        }
    }
};